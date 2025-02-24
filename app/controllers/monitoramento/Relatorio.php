<?php

namespace App\Controllers\Monitoramento;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Relatorio {
    public static function gerarRelatorioGeral($dados) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Relatório Geral de Desempenho');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E1F2');

        $sheet->setCellValue('A3', 'Categoria');
        $sheet->setCellValue('B3', 'Total Alunos');
        $sheet->setCellValue('C3', 'Média de Porcentagem');
        $sheet->setCellValue('D3', 'Porcentagem Acima de 60%');
        $sheet->getStyle('A3:D3')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3:D3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFBDD7EE');
        $sheet->getStyle('A3:D3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $row = 4;
        foreach ($dados['geral'] as $categoria => $info) {
            if (isset($info['total_alunos'])) {
                $sheet->setCellValue('A'.$row, ucfirst($categoria));
                $sheet->setCellValue('B'.$row, $info['total_alunos']);
                $sheet->setCellValue('C'.$row, $info['media_porcentagem'].'%');
                $sheet->setCellValue('D'.$row, $info['porcentagem_acima_60'].'%');
                self::aplicarEstiloPadrao($sheet, 'A'.$row.':D'.$row);
                $row++;
            }
        }

        $row += 2;
        $sectionTitles = [
            'por_turma' => 'Relatório por Turma',
            'por_serie' => 'Relatório por Série',
            'por_turno' => 'Relatório por Turno',
            'por_disciplina' => 'Relatório por Disciplina'
        ];

        foreach ($sectionTitles as $key => $title) {
            if (isset($dados['geral'][$key])) {
                $sheet->setCellValue('A'.$row, $title);
                $sheet->mergeCells('A'.$row.':D'.$row);
                $sheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A'.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE2EFDA');
                $row++;
                foreach ($dados['geral'][$key] as $categoria => $items) {
                    $sheet->setCellValue('A'.$row, ucfirst($categoria));
                    $sheet->mergeCells('A'.$row.':D'.$row);
                    $sheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(14);
                    $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('A'.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFBDD7EE');
                    $row++;
                    $rotulo = $key == 'por_disciplina' ? 'Disciplina' : ($key == 'por_turma' ? 'Turma' : ($key == 'por_serie' ? 'Série' : ($key == 'por_turno' ? 'Turno' : '')));
                    $sheet->setCellValue('A'.$row, $rotulo);
                    $sheet->setCellValue('B'.$row, 'Total Alunos');
                    $sheet->setCellValue('C'.$row, 'Média de Porcentagem');
                    $sheet->setCellValue('D'.$row, 'Porcentagem Acima de 60%');
                    $sheet->getStyle('A'.$row.':D'.$row)->getFont()->setBold(true)->setSize(12);
                    $sheet->getStyle('A'.$row.':D'.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE2EFDA');
                    $sheet->getStyle('A'.$row.':D'.$row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                    $row++;
                    foreach ($items as $itemKey => $item) {
                        $sheet->setCellValue('A'.$row, $itemKey);
                        $sheet->setCellValue('B'.$row, $item['total_alunos']);
                        $sheet->setCellValue('C'.$row, $item['media_porcentagem'].'%');
                        $sheet->setCellValue('D'.$row, $item['porcentagem_acima_60'].'%');
                        self::aplicarEstiloPadrao($sheet, 'A'.$row.':D'.$row);
                        $row++;
                    }
                    $row++;
                }
            }
        }

        if (isset($dados['por_periodo'])) {
            $sheet->setCellValue('A'.$row, 'Relatório por Período');
            $sheet->mergeCells('A'.$row.':D'.$row);
            $sheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A'.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE2EFDA');
            $row++;
            $startPeriodRow = $row;
            $colunaInicial = 1;
            foreach ($dados['por_periodo'] as $categoria => $periodos) {
                $colAtual = $colunaInicial;
                $currentRow = $startPeriodRow;
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colAtual).$currentRow, ucfirst($categoria));
                $sheet->mergeCells(Coordinate::stringFromColumnIndex($colAtual).$currentRow.':'.Coordinate::stringFromColumnIndex($colAtual+2).$currentRow);
                $sheet->getStyle(Coordinate::stringFromColumnIndex($colAtual).$currentRow)->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle(Coordinate::stringFromColumnIndex($colAtual).$currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle(Coordinate::stringFromColumnIndex($colAtual).$currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFBDD7EE');
                $currentRow++;
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colAtual).$currentRow, 'Período');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colAtual+1).$currentRow, 'Média de Porcentagem');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colAtual+2).$currentRow, 'Porcentagem Acima de 60%');
                $sheet->getStyle(Coordinate::stringFromColumnIndex($colAtual).$currentRow.':'.Coordinate::stringFromColumnIndex($colAtual+2).$currentRow)->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle(Coordinate::stringFromColumnIndex($colAtual).$currentRow.':'.Coordinate::stringFromColumnIndex($colAtual+2).$currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE2EFDA');
                $sheet->getStyle(Coordinate::stringFromColumnIndex($colAtual).$currentRow.':'.Coordinate::stringFromColumnIndex($colAtual+2).$currentRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $currentRow++;
                foreach ($periodos as $periodo => $detalhes) {
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($colAtual).$currentRow, $periodo);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($colAtual+1).$currentRow, $detalhes['media_porcentagem'].'%');
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($colAtual+2).$currentRow, $detalhes['porcentagem_acima_60'].'%');
                    self::aplicarEstiloPadrao($sheet, Coordinate::stringFromColumnIndex($colAtual+1).$currentRow.':'.Coordinate::stringFromColumnIndex($colAtual+2).$currentRow);
                    $currentRow++;
                    if (isset($detalhes['turmas']) && is_array($detalhes['turmas'])) {
                        foreach ($detalhes['turmas'] as $turma => $turmaInfo) {
                            $sheet->setCellValue(Coordinate::stringFromColumnIndex($colAtual).$currentRow, ' - '.$turma);
                            $sheet->setCellValue(Coordinate::stringFromColumnIndex($colAtual+1).$currentRow, $turmaInfo['media_porcentagem'].'%');
                            $sheet->setCellValue(Coordinate::stringFromColumnIndex($colAtual+2).$currentRow, $turmaInfo['porcentagem_acima_60'].'%');
                            self::aplicarEstiloPadrao($sheet, Coordinate::stringFromColumnIndex($colAtual+1).$currentRow.':'.Coordinate::stringFromColumnIndex($colAtual+2).$currentRow);
                            $currentRow++;
                            if (isset($turmaInfo['disciplinas']) && is_array($turmaInfo['disciplinas'])) {
                                foreach ($turmaInfo['disciplinas'] as $disciplina => $disciplinaInfo) {
                                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($colAtual).$currentRow, '   - '.$disciplina);
                                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($colAtual+1).$currentRow, $disciplinaInfo['media_porcentagem'].'%');
                                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($colAtual+2).$currentRow, $disciplinaInfo['porcentagem_acima_60'].'%');
                                    self::aplicarEstiloPadrao($sheet, Coordinate::stringFromColumnIndex($colAtual+1).$currentRow.':'.Coordinate::stringFromColumnIndex($colAtual+2).$currentRow);
                                    $currentRow++;
                                }
                            }
                        }
                    }
                }
                $colunaInicial += 4;
            }
        }

        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'relatorio_geral.xlsx';
        $writer->save($filename);
        return $filename;
    }

    private static function aplicarEstiloPadrao($sheet, $range) {
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
        $coordinateRange = Coordinate::rangeBoundaries($range);
        for ($row = $coordinateRange[0][1]; $row <= $coordinateRange[1][1]; $row++) {
            for ($col = $coordinateRange[0][0]; $col <= $coordinateRange[1][0]; $col++) {
                $cellCoordinate = Coordinate::stringFromColumnIndex($col).$row;
                $cell = $sheet->getCell($cellCoordinate);
                $value = (float) str_replace('%','',$cell->getValue());
                $color = 'FFC6EFCE';
                if ($value < 60) {
                    $color = 'FFFFCCCC';
                } elseif ($value < 80) {
                    $color = 'FFFFFFCC';
                }
                $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($color);
            }
        }
    }
}