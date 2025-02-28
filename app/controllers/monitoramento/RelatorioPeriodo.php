<?php

namespace App\Controllers\Monitoramento;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class RelatorioPeriodo {

    public static function gerarRelatorioGeral($dados) {
        $spreadsheet = new Spreadsheet();

        foreach ($dados['geral'] as $categoria => $info) {
            self::criarAbaGeral($spreadsheet, $categoria, $info);
        }

        foreach ($dados['por_periodo'] as $categoria => $periodos) {
            self::criarAbaPorPeriodo($spreadsheet, $categoria, $periodos);
        }

        $spreadsheet->removeSheetByIndex(0);

        $writer = new Xlsx($spreadsheet);
        $filename = 'relatorio_geral.xlsx';
        $writer->save($filename);

        return $filename;
    }

    private static function criarAbaGeral($spreadsheet, $categoria, $info) {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle(ucfirst($categoria) . ' - Geral');

        $sheet->setCellValue('A1', 'Relatório Geral - ' . ucfirst($categoria));
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E1F2');

        $sheet->setCellValue('A3', 'Métrica');
        $sheet->setCellValue('B3', 'Média de Porcentagem');
        $sheet->setCellValue('C3', 'Porcentagem Acima de 60%');
        $sheet->getStyle('A3:C3')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3:C3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFBDD7EE');
        $sheet->getStyle('A3:C3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $sheet->setCellValue('A4', 'Média Geral');
        $sheet->setCellValue('B4', $info['media_porcentagem'] . '%');
        $sheet->setCellValue('C4', $info['porcentagem_acima_60'] . '%');

        self::aplicarEstiloPorcentagem($sheet, 'B4:C4');

        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    private static function criarAbaPorPeriodo($spreadsheet, $categoria, $periodos) {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle(ucfirst($categoria) . ' - Por Período');

        $sheet->setCellValue('A1', 'Relatório por Período - ' . ucfirst($categoria));
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E1F2');

        $row = 3;

        foreach ($periodos as $periodo => $detalhes) {
            $sheet->setCellValue('A' . $row, $periodo);
            $sheet->mergeCells('A' . $row . ':C' . $row);
            $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE2EFDA');
            $row++;

            $sheet->setCellValue('A' . $row, 'Turma');
            $sheet->setCellValue('B' . $row, 'Média de Porcentagem');
            $sheet->setCellValue('C' . $row, 'Porcentagem Acima de 60%');
            $sheet->getStyle('A' . $row . ':C' . $row)->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A' . $row . ':C' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFBDD7EE');
            $sheet->getStyle('A' . $row . ':C' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $row++;

            foreach ($detalhes['turmas'] as $turma => $turmaInfo) {
                $sheet->setCellValue('A' . $row, $turma);
                $sheet->setCellValue('B' . $row, $turmaInfo['media_porcentagem'] . '%');
                $sheet->setCellValue('C' . $row, $turmaInfo['porcentagem_acima_60'] . '%');
                self::aplicarEstiloPorcentagem($sheet, 'B' . $row . ':C' . $row);
                $row++;

                foreach ($turmaInfo['disciplinas'] as $disciplina => $disciplinaInfo) {
                    $sheet->setCellValue('A' . $row, ' - ' . $disciplina);
                    $sheet->setCellValue('B' . $row, $disciplinaInfo['media_porcentagem'] . '%');
                    $sheet->setCellValue('C' . $row, $disciplinaInfo['porcentagem_acima_60'] . '%');
                    self::aplicarEstiloPorcentagem($sheet, 'B' . $row . ':C' . $row);
                    $row++;
                }
            }
            $row++;
        }

        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    private static function aplicarEstiloPorcentagem($sheet, $range) {
        $style = [
            'font' => [
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->getStyle($range)->applyFromArray($style);

        $coordinateRange = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::rangeBoundaries($range);

        for ($row = $coordinateRange[0][1]; $row <= $coordinateRange[1][1]; $row++) {
            for ($col = $coordinateRange[0][0]; $col <= $coordinateRange[1][0]; $col++) {
                $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $row;
                $cell = $sheet->getCell($cellCoordinate);
                $value = (float) str_replace('%', '', $cell->getValue());

                $color = 'FFC6EFCE';
                if ($value < 60) {
                    $color = 'FFFFCCCC';
                } elseif ($value < 80) {
                    $color = 'FFFFFFCC';
                }

                $cell->getStyle()->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB($color);
            }
        }
    }
}