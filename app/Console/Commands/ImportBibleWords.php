<?php

namespace App\Console\Commands;

use App\Models\BibleWord;
use Illuminate\Console\Command;
use Smalot\PdfParser\Parser;

class ImportBibleWords extends Command
{
    protected $signature = 'bible:import';

    protected $description = 'Extract all unique words from bible.pdf and store them in the database';

    public function handle(): int
    {
        $path = storage_path('app/private/bible.pdf');

        if (! file_exists($path)) {
            $this->error('bible.pdf not found in storage/app/private/');
            return self::FAILURE;
        }

        $this->info('Parsing PDF...');

        $parser = new Parser();
        $pdf = $parser->parseFile($path);
        $text = $pdf->getText();

        $this->info('Extracting words...');

        // Split on whitespace, keep Unicode letters and apostrophes, lowercase, deduplicate
        $words = preg_split('/\s+/u', $text);
        $words = array_map(function ($word) {
            // Remove anything that isn't a Unicode letter or apostrophe
            $word = preg_replace("/[^\p{L}']/u", '', $word);
            return mb_strtolower(trim($word, "'"));
        }, $words);

        // Remove empty strings and deduplicate
        $words = array_unique(array_filter($words));

        $this->info('Found ' . count($words) . ' unique words.');

        $this->info('Inserting into database...');

        $bar = $this->output->createProgressBar(count($words));
        $bar->start();

        // Insert in chunks for performance
        foreach (array_chunk($words, 500) as $chunk) {
            $records = array_map(fn ($word) => ['word' => $word], $chunk);
            BibleWord::upsert($records, ['word']);
            $bar->advance(count($chunk));
        }

        $bar->finish();
        $this->newLine();

        $total = BibleWord::count();
        $this->info("Done! {$total} unique words stored in the database.");

        return self::SUCCESS;
    }
}
