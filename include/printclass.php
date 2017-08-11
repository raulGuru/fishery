<?php
require_once (__DIR__ . '/escpos-php/autoload.php');

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

function execprint($obj)
{
    try {

        $tslot = array(
            "10" => "10:00 AM - 11:00 AM",
            "11" => "11:00 AM - 12:00 PM",
            "12" => "12:00 PM - 1:00 PM",
            "13" => "1:00 PM - 2:00 PM",
            "14" => "2:00 PM - 3:00 PM",
            "15" => "3:00 PM - 4:00 PM",
            "16" => "4:00 PM - 5:00 PM",
            "17" => "5:00 PM - 6:00 PM",
            "18" => "6:00 PM - 7:00 PM",
            "19" => "7:00 PM - 8:00 PM",
            "20" => "8:00 PM - 9:00 PM"
        );
        $booking = $obj['booking'];
        $visitors = $obj['visitor'];
        $invoice = $obj['invoice'];

        /* img logo*/
        $logo = EscposImage::load(__DIR__ . '/../assets/images/dolphin.png', false);
        $sponsorlogo = EscposImage::load(__DIR__ . '/../assets/images/mahanagargaslogo.png', false);

        $connector = new WindowsPrintConnector("EPSON TM-T82II Receipt");
        $printer = new Printer($connector);

        /* header */
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> setTextSize(1, 2);
        $printer -> setUnderline(Printer::UNDERLINE_DOUBLE);
        $printer -> text("Government of Maharashtra\n");
        $printer -> setUnderline(Printer::UNDERLINE_NONE);

        /* Print top logo */
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($logo);

        /* sponsor */
        $printer -> setTextSize(2, 1);
        $printer -> setEmphasis(true);
        $printer -> text("Taraporevala Aquarium\n");
        $printer -> setEmphasis(false);
        $printer -> graphics($sponsorlogo);
        $printer -> text(str_repeat("-", 24)."\n");

        /* ticket transaction id and date */
        $printer -> setTextSize(1, 1);
        $printer -> setEmphasis(true);
        $printer -> text("Tran ID: ". $invoice->transactionid . "\n");
        $printer -> setEmphasis(false);
        $printer -> text("Current Date/Time: ". date('d-m-Y h:i A') ."\n");
        $printer -> text(date('d M Y') ."  ". $tslot[$booking->time] . "\n");

        /* items header */
        $printer -> setJustification();
        $printer->text(str_repeat("-", 48)."\n");
        $printer->setEmphasis(true);
        $printer->text("      Category Type          Count    Amt(Rs)   \n");
        $printer->setEmphasis(false);

        /* items */
        $printer->text(str_repeat("-", 48)."\n");
        foreach ($visitors as $visitor)
        {
            $itm = split_on($visitor['name'], 21);
            $itml = str_pad($itm[0], 24, ' ', STR_PAD_RIGHT);
            $ct = str_pad($visitor['adult'], 9, ' ', STR_PAD_LEFT);
            $amt = str_pad($visitor['totalamount'], 10, ' ', STR_PAD_LEFT);

            $printer->text("$itml$ct$amt\n");

            if(!empty($itm[1])) {
                //$printer->text("  $itm[1]\n\n");
                $printer->text("$itm[1]\n");
            }else {
                //$printer->text("\n");
            }
        }

        /* item total */
        $tl = str_pad('Total', 24, ' ', STR_PAD_BOTH);
        $tct = str_pad($invoice->adult, 9, ' ', STR_PAD_LEFT);
        $tamt = str_pad($invoice->visitoramount, 10, ' ', STR_PAD_LEFT);

        $printer->text(str_repeat("-", 48)."\n");
        $printer->setEmphasis(true);
        $printer->text("$tl$tct$tamt\n");
        $printer->setEmphasis(false);
        $printer->text(str_repeat("-", 48)."\n");

        /* photography */
        if(!empty($invoice->visitoramount))
        {
            $pn = str_pad(($invoice->name) . ' Photography', 38, ' ', STR_PAD_RIGHT);
            $pamt = str_pad($invoice->photographyamount, 9, ' ', STR_PAD_RIGHT);

            $printer->text("$pn$pamt\n");

            /* grand total */
            $gtl = str_pad('Sub-total', 38, ' ', STR_PAD_BOTH);
            $gtr = str_pad(($invoice->visitoramount + $invoice->photographyamount), 9, ' ', STR_PAD_RIGHT);

            $printer->text(str_repeat("-", 48)."\n");
            $printer->setEmphasis(true);
            $printer->text("$gtl$gtr\n");
            $printer->setEmphasis(false);
            $printer->text(str_repeat("-", 48)."\n");
        }

        $printer -> cut();
        $printer -> close();

    }catch (Exception $e) {
        echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    }
}

function split_on($string, $num)
{
    $length = strlen($string);
    $output[0] = trim(substr($string, 0, $num));
    $output[1] = trim(substr($string, $num, $length ));
    return $output;
}