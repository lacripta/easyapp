<?php

namespace controllers;

use DateTime;

class PDF extends \controllers\FPDF {

    private $_sistema;

    public function __construct() {
        $this->_sistema = new \models\archivo\Sistema();
    }

    function LoadData($file) {
        // Leer las líneas del fichero
    }

// Tabla coloreada
    function index() {
        date_default_timezone_set('America/Bogota');
        //$fecha = filter_input(INPUT_POST, "fecha_inicio");
        $dt_min = new DateTime(filter_input(INPUT_POST, "inicio"));
        $dt_max = new DateTime(filter_input(INPUT_POST, "fin"));
        $categoria = filter_input(INPUT_POST, "categoria") != "" ? filter_input(INPUT_POST, "categoria") : "Todas las Categorias";
        FPDF::FPDF();
        $this->SetTitle($categoria);
        $info = array();
        $tmp = $this->_sistema->documentosArchivo($categoria, filter_input(INPUT_POST, "inicio"), filter_input(INPUT_POST, "fin"));
        if (count($tmp) > 0) {
            foreach ($tmp as $elemento) {
                $info[] = "$elemento->documento_secuencia;$elemento->documento_persona_nombre;$elemento->documento_persona_apellido;$elemento->documento_persona_rif;$elemento->documento_fecha;$elemento->documento_estado;$elemento->documento_asunto;$elemento->documento_destino";
            }

            $header = ['#', 'Nombre', 'Apellido', 'RIF', 'Fecha', 'Estado', 'Asunto', 'Destino'];
            $data = array();
            foreach ($info as $line) {
                $data[] = explode(';', trim($line));
            }
            $total = count($data);
            $actual = 0;
            for ($y = 0; ceil($y < $total / 20); $y++) {
                $this->AddPage('H', 'Letter');
                $this->Image("img/header.jpg");
                $this->SetFont('Arial', '', 10);
                $this->Cell(0, 10, "Reporte de " . $categoria, "B", 1, "C");
                $this->Rect($this->GetX(), $this->GetY() + 15, 265, 20);
                $this->Text($this->GetX() + 5, $this->GetY() + 20, "Datos de $categoria");
                $this->Text(20, $this->GetY() + 10, "Inicio: " . $dt_min->format('Y-m-d'));
                $this->Text(60, $this->GetY() + 10, "Fin: " . $dt_max->format('Y-m-d'));
                $this->Text(255, $this->GetY() + 10, "Pag: " . $this->PageNo());
                $this->Ln(30);

                // Colores, ancho de línea y fuente en negrita
                $this->SetFillColor(150, 60, 0);
                $this->SetTextColor(255);
                $this->SetDrawColor(128, 0, 0);
                $this->SetLineWidth(.3);
                $this->SetFont('arial', 'B');
                // Cabecera
                $w = array(10, 25, 25, 30, 40, 30, 55, 50);
                for ($i = 0; $i < count($header); $i++) {
                    $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
                }
                $this->Ln();
                // Restauración de colores y fuentes
                $this->SetFillColor(224, 235, 255);
                $this->SetTextColor(0);
                $this->SetFont('');
                // Datos
                $fill = false;
                $row = $data;
                for ($x = $actual; $x < $actual + 20; $x++) {
                    $this->Cell($w[0], 6, utf8_decode($row[$x][0]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[1], 6, utf8_decode($row[$x][1]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[2], 6, utf8_decode($row[$x][2]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[3], 6, utf8_decode($row[$x][3]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[4], 6, utf8_decode($row[$x][4]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[5], 6, utf8_decode($row[$x][5]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[6], 6, utf8_decode($row[$x][6]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[7], 6, utf8_decode($row[$x][7]), 'LR', 0, 'C', $fill);
                    $this->Ln();
                    $fill = !$fill;
                }
                $actual = $x;
            }
            // Línea de cierre
            $this->Cell(array_sum($w), 0, '', 'T');
            $this->Output();
        } else {
            $header = ['#', 'Nombre', 'Apellido', 'RIF', 'Fecha', 'Estado', 'Asunto', 'Destino'];
            $actual = 0;
            $this->AddPage('H', 'Letter');
            $this->Image("img/header.jpg");
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 10, "Reporte de " . $categoria, "B", 1, "C");
            $this->Rect($this->GetX(), $this->GetY() + 15, 265, 20);
            $this->Text($this->GetX() + 5, $this->GetY() + 20, "Datos de $categoria");
            $this->Text(20, $this->GetY() + 10, "Inicio: " . $dt_min->format('Y-m-d'));
            $this->Text(60, $this->GetY() + 10, "Fin: " . $dt_max->format('Y-m-d'));
            $this->Text(255, $this->GetY() + 10, "Pag: " . $this->PageNo());
            $this->Ln(30);

            // Colores, ancho de línea y fuente en negrita
            $this->SetFillColor(150, 60, 0);
            $this->SetTextColor(255);
            $this->SetDrawColor(128, 0, 0);
            $this->SetLineWidth(.3);
            $this->SetFont('arial', 'B');
            // Cabecera
            $w = array(10, 25, 25, 30, 40, 30, 55, 50);
            for ($i = 0; $i < count($header); $i++) {
                $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
            }
            $this->Ln();
            // Lnea de cierre
            $this->Cell(array_sum($w), 0, '', 'T');
            $this->Output();
        }
    }

    public function mensual() {
        date_default_timezone_set('America/Bogota');
        //$fecha = filter_input(INPUT_POST, "fecha_inicio");
        $fecha = filter_input(INPUT_POST, "year") . "-" . filter_input(INPUT_POST, "mes") . "-01";
        $dt_min = new DateTime($fecha);
        $dt_max = clone($dt_min);
        $categoria = filter_input(INPUT_POST, "categoria") != "" ? filter_input(INPUT_POST, "categoria") : "Todas las Categorias";
        FPDF::FPDF();
        $this->SetTitle($categoria);
        $info = array();
        $tmp = $this->_sistema->documentosArchivo($categoria, $dt_min->format('Y-m-d'), $dt_min->format('Y-m-t'));
        if (count($tmp) > 0) {
            foreach ($tmp as $elemento) {
                $info[] = "$elemento->documento_secuencia;$elemento->documento_persona_nombre;$elemento->documento_persona_apellido;$elemento->documento_persona_rif;$elemento->documento_fecha;$elemento->documento_estado;$elemento->documento_asunto;$elemento->documento_destino";
            }

            $header = ['#', 'Nombre', 'Apellido', 'RIF', 'Fecha', 'Estado', 'Asunto', 'Destino'];
            $data = array();
            foreach ($info as $line) {
                $data[] = explode(';', trim($line));
            }
            $total = count($data);
            $actual = 0;
            for ($y = 0; ceil($y < $total / 20); $y++) {
                $this->AddPage('H', 'Letter');
                $this->Image("img/header.jpg");
                $this->SetFont('Arial', '', 10);
                $this->Cell(0, 10, "Reporte Mensual de " . $categoria, "B", 1, "C");
                $this->Rect($this->GetX(), $this->GetY() + 15, 265, 20);
                $this->Text($this->GetX() + 5, $this->GetY() + 20, "Datos de $categoria");
                $this->Text(20, $this->GetY() + 10, "Inicio: " . $dt_min->format('Y-m-d'));
                $this->Text(60, $this->GetY() + 10, "Fin: " . $dt_max->format('Y-m-t'));
                $this->Text(255, $this->GetY() + 10, "Pag: " . $this->PageNo());
                $this->Ln(30);

                // Colores, ancho de línea y fuente en negrita
                $this->SetFillColor(150, 60, 0);
                $this->SetTextColor(255);
                $this->SetDrawColor(128, 0, 0);
                $this->SetLineWidth(.3);
                $this->SetFont('arial', 'B');
                // Cabecera
                $w = array(10, 25, 25, 30, 40, 30, 55, 50);
                for ($i = 0; $i < count($header); $i++) {
                    $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
                }
                $this->Ln();
                // Restauración de colores y fuentes
                $this->SetFillColor(224, 235, 255);
                $this->SetTextColor(0);
                $this->SetFont('');
                // Datos
                $fill = false;
                $row = $data;
                for ($x = $actual; $x < $actual + 20; $x++) {
                    $this->Cell($w[0], 6, utf8_decode($row[$x][0]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[1], 6, utf8_decode($row[$x][1]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[2], 6, utf8_decode($row[$x][2]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[3], 6, utf8_decode($row[$x][3]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[4], 6, utf8_decode($row[$x][4]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[5], 6, utf8_decode($row[$x][5]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[6], 6, utf8_decode($row[$x][6]), 'LR', 0, 'C', $fill);
                    $this->Cell($w[7], 6, utf8_decode($row[$x][7]), 'LR', 0, 'C', $fill);
                    $this->Ln();
                    $fill = !$fill;
                }
                $actual = $x;
            }
            // Línea de cierre
            $this->Cell(array_sum($w), 0, '', 'T');
            $this->Output();
        } else {
            $header = ['#', 'Nombre', 'Apellido', 'RIF', 'Fecha', 'Estado', 'Asunto', 'Destino'];
            $actual = 0;
            $this->AddPage('H', 'Letter');
            $this->Image("img/header.jpg");
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 10, "Reporte Mensual de " . $categoria, "B", 1, "C");
            $this->Rect($this->GetX(), $this->GetY() + 15, 265, 20);
            $this->Text($this->GetX() + 5, $this->GetY() + 20, "Datos de $categoria");
            $this->Text(20, $this->GetY() + 10, "Inicio: " . $dt_min->format('Y-m-d'));
            $this->Text(60, $this->GetY() + 10, "Fin: " . $dt_max->format('Y-m-t'));
            $this->Text(255, $this->GetY() + 10, "Pag: " . $this->PageNo());
            $this->Ln(30);

            // Colores, ancho de línea y fuente en negrita
            $this->SetFillColor(150, 60, 0);
            $this->SetTextColor(255);
            $this->SetDrawColor(128, 0, 0);
            $this->SetLineWidth(.3);
            $this->SetFont('arial', 'B');
            // Cabecera
            $w = array(10, 25, 25, 30, 40, 30, 55, 50);
            for ($i = 0; $i < count($header); $i++) {
                $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
            }
            $this->Ln();
            // Lnea de cierre
            $this->Cell(array_sum($w), 0, '', 'T');
            $this->Output();
        }
    }

}
