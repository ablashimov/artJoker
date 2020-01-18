<?php

namespace App\Services\Csv;

final class CsvExporter
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function export(): string
    {
        $output = fopen('php://output', 'w');
        ob_start();
        fputcsv($output, array_keys($this->data[0]));

        foreach ($this->data as $student) {
            fputcsv($output, $student);
        }

        $csvString = ob_get_clean();
        $this->setHeaders();

        return $csvString;
    }

    private function setHeaders()
    {
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
    }
}