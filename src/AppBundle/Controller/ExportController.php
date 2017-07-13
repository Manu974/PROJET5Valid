<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Bird;
use AppBundle\Entity\Observation;
use AppBundle\Entity\ObservationImage;
use AppBundle\Form\ObservationType;
use AppBundle\Form\ObservationEspaceProType;
use AppBundle\Form\ObservationCarteType;
use AppBundle\Form\BirdType;
use AppBundle\Form\ObservationImageType;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;
use Goodby\CSV\Export\Standard\ExporterConfig;
use Goodby\CSV\Export\Standard\Exporter;
use Goodby\CSV\Export\Standard\CsvFileObject;
use Goodby\CSV\Export\Standard\Collection\PdoCollection;
use Goodby\CSV\Export\Standard\Collection\CallbackCollection;



class ExportController extends Controller
{
    

     /**
     * @Route("/observation/espacepro/export", name="export")
     * 
     */
    public function csvExportAction()
	{
		$conn = $this->get('database_connection');

		$stmt = $conn->prepare('SELECT * FROM observation');
		$stmt->execute();

		$response = new StreamedResponse();
		$response->setStatusCode(200);
		$response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');

		$response->headers->set('Content-Type', 'text/csv');
		$response->setCallback(function() use($stmt) {
			$config = new ExporterConfig();
			$config
			->setDelimiter(";") // Customize delimiter. Default value is comma(,)
			->setEnclosure("'")  // Customize enclosure. Default value is double quotation(")
			//->setEscape("\\")    // Customize escape character. Default value is backslash(\)
			->setToCharset('SJIS-win') // Customize file encoding. Default value is null, no converting.
			->setFromCharset('UTF-8') // Customize source encoding. Default value is null.
			->setFileMode(CsvFileObject::FILE_MODE_WRITE) // Customize file mode and choose either write or append. Default value is write ('w'). See fopen() php docs
			;
			$exporter = new Exporter($config);

			$exporter->export('php://output', new PdoCollection($stmt->getIterator()));
		});
		$response->send();

		return $response;
	}

}