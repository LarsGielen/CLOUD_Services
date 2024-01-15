<?php

require_once 'vendor/autoload.php';
require_once 'models.php';
require_once 'database.php';

use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;

class AbcToPDFConverter {

    /**
     * @param SheetMusic $sheetMusic the abc notation of the music to convert
     * @return string|null the fileName of the pdf
     */
    public function convert($sheetMusic) {

        if ($sheetMusic == null) {
            return null;
        }

        $htmlFilePath = __DIR__ . DIRECTORY_SEPARATOR . "musicSheetConverter.html";
        $outputPdfPath = 'pdfs/' . str_replace(' ', '_', $sheetMusic->getMusicTitle()) . '_' . date('YmdHis') . '.pdf';

        if (!is_dir('pdfs/')) {
            mkdir('pdfs/', 0777, true);
        }

        try {
            // Load the HTML file
            $puppeteer = new Puppeteer();
            $browser = $puppeteer->launch();
            $page = $browser->newPage();
            $page->goto("file://" . $htmlFilePath);
            $page->evaluate(JsFunction::createWithBody('
                renderNotation(`' . $sheetMusic->getAbcNotation() . '`);
            '));
    
            // Save the PDF
            $page->pdf(['path' => $outputPdfPath, 'format' => 'A4']);
            $browser->close();
        }
        catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }

        error_log("generated pdf successfully: $outputPdfPath");
        return $outputPdfPath;
    }
}

?>