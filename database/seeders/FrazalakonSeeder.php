<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FrazalakonSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('frazalakons')->truncate();

        $sql = file_get_contents(base_path('fzk.sql'));

        // Extract the INSERT INTO `frazalakon` VALUES (...) statement
        if (! preg_match("/INSERT INTO `frazalakon` VALUES (.+);/", $sql, $match)) {
            $this->command->error('No frazalakon INSERT found in fzk.sql');

            return;
        }

        $valuesStr = $match[1];
        $rows = $this->parseMysqlValues($valuesStr);

        $columns = [
            'id', 'user_id', 'group_id', 'body', 'who', 'towho',
            'context', 'where', 'when', 'author', 'published_at',
            'public', 'heart_count', 'created_at', 'updated_at',
        ];

        $chunks = array_chunk($rows, 100);

        foreach ($chunks as $chunk) {
            $insert = [];
            foreach ($chunk as $row) {
                $record = [];
                foreach ($columns as $i => $col) {
                    $val = $row[$i] ?? null;
                    $record[$col] = $val === 'NULL' ? null : $val;
                }
                $insert[] = $record;
            }
            DB::table('frazalakons')->insert($insert);
        }

        // Reset the sequence to match the max id
        $maxId = DB::table('frazalakons')->max('id');
        DB::statement("SELECT setval('frazalakons_id_seq', $maxId)");

        $this->command->info('Imported '.count($rows).' frazalakons.');
    }

    /**
     * Parse MySQL VALUES (...),(...),... into an array of row arrays.
     */
    private function parseMysqlValues(string $input): array
    {
        $rows = [];
        $i = 0;
        $len = strlen($input);

        while ($i < $len) {
            // Find opening paren
            if ($input[$i] === '(') {
                $i++;
                $row = [];
                $value = '';
                $inString = false;
                $escape = false;

                while ($i < $len) {
                    $ch = $input[$i];

                    if ($escape) {
                        if ($ch === '\'') {
                            $value .= "'";
                        } elseif ($ch === 'n') {
                            $value .= "\n";
                        } elseif ($ch === 'r') {
                            $value .= "\r";
                        } elseif ($ch === 't') {
                            $value .= "\t";
                        } elseif ($ch === '\\') {
                            $value .= '\\';
                        } else {
                            $value .= $ch;
                        }
                        $escape = false;
                        $i++;

                        continue;
                    }

                    if ($inString) {
                        if ($ch === '\\') {
                            $escape = true;
                            $i++;

                            continue;
                        }
                        if ($ch === '\'') {
                            $inString = false;
                            $i++;

                            continue;
                        }
                        $value .= $ch;
                        $i++;

                        continue;
                    }

                    // Not in string
                    if ($ch === '\'') {
                        $inString = true;
                        $i++;

                        continue;
                    }
                    if ($ch === ',' || $ch === ')') {
                        $row[] = trim($value);
                        $value = '';
                        if ($ch === ')') {
                            $i++;
                            break;
                        }
                        $i++;

                        continue;
                    }

                    $value .= $ch;
                    $i++;
                }

                $rows[] = $row;
            } else {
                $i++;
            }
        }

        return $rows;
    }
}
