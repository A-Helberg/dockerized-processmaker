<?php
namespace ProcessMaker\Exporter;

use ProcessMaker\Util;

/**
 * Class XmlExporter
 *
 * @package ProcessMaker\Exporter
 * @author Erik Amaru Ortiz <erik@coilosa.com>
 */
class XmlExporter extends Exporter
{
    /**
     * @var \DOMDocument
     */
    protected $dom;

    /**
     * @var \DOMElement
     */
    protected $rootNode;

    /**
     * XmlExporter Constructor
     *
     * @param $prjUid
     *
     */
    public function __construct($prjUid)
    {
        parent::__construct($prjUid);

        $this->dom = new \DOMDocument("1.0", "utf-8");
        $this->dom->formatOutput = true;
    }

    /**
     * @inherits
     */
    public function build()
    {
        $this->rootNode = $this->dom->createElement(self::getContainerName());
        $this->rootNode->setAttribute("version", self::getVersion());
        $this->dom->appendChild($this->rootNode);

        $data = $this->buildData();

        // metadata set up
        $metadata = $data["metadata"];
        $metadataNode = $this->dom->createElement("metadata");

        foreach ($metadata as $key => $value) {
            $metaNode = $this->dom->createElement("meta");
            $metaNode->setAttribute("key", $key);
            $metaNode->appendChild($this->getTextNode($value));
            $metadataNode->appendChild($metaNode);
        }

        $this->rootNode->appendChild($metadataNode);
        // end setting metadata

        // bpmn struct data set up
        $dbData = array("BPMN" => $data["bpmn-definition"], "workflow" => $data["workflow-definition"]);

        foreach ($dbData as $sectionName => $sectionData) {
            $dataNode = $this->dom->createElement("definition");
            $dataNode->setAttribute("class", $sectionName);

            foreach ($sectionData as $elementName => $elementData) {
                $elementNode = $this->dom->createElement("table");
                $elementNode->setAttribute("name", $elementName);

                foreach ($elementData as $recordData) {
                    $recordNode = $this->dom->createElement("record");
                    $recordData = array_change_key_case($recordData, CASE_LOWER);

                    foreach ($recordData as $key => $value) {
                        $columnNode = $this->dom->createElement($key);
                        $columnNode->appendChild($this->getTextNode($value));
                        $recordNode->appendChild($columnNode);
                    }

                    $elementNode->appendChild($recordNode);
                }

                $dataNode->appendChild($elementNode);
            }

            $this->rootNode->appendChild($dataNode);
        }

        $workflowFilesNode = $this->dom->createElement("workflow-files");

        // workflow dynaforms files
        foreach ($data["workflow-files"] as $elementName => $elementData) {
            foreach ($elementData as $fileData) {
                $fileNode = $this->dom->createElement("file");
                $fileNode->setAttribute("target", strtolower($elementName));

                $filenameNode = $this->dom->createElement("file_name");
                $filenameNode->appendChild($this->getTextNode($fileData["filename"]));
                $fileNode->appendChild($filenameNode);

                $filepathNode = $this->dom->createElement("file_path");
                $filepathNode->appendChild($this->dom->createCDATASection($fileData["filepath"]));
                $fileNode->appendChild($filepathNode);

                $fileContentNode = $this->dom->createElement("file_content");
                $fileContentNode->appendChild($this->dom->createCDATASection(base64_encode($fileData["file_content"])));
                $fileNode->appendChild($fileContentNode);

                $workflowFilesNode->appendChild($fileNode);
            }
        }

        $this->rootNode->appendChild($workflowFilesNode);
    }

    /**
     * @inherits
     */
    public function saveExport($outputFile)
    {
        $parentDir = dirname($outputFile);

        if (! is_dir($parentDir)) {
            Util\Common::mk_dir($parentDir, 0775);
        }

        file_put_contents($outputFile, $this->export());
        chmod($outputFile, 0755);
    }

    /**
     * @inherits
     */
    public function export()
    {
        $this->build();
        return $this->dom->saveXml();
    }

    private function getTextNode($value)
    {
        if (empty($value) || preg_match('/^[\w\s\.\-]+$/', $value, $match)) {
            return $this->dom->createTextNode($value);
        } else {
            return $this->dom->createCDATASection($value);
        }
    }
}