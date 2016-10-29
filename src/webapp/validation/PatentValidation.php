<?php

namespace tdt4237\webapp\validation;

use tdt4237\webapp\models\Patent;

class PatentValidation {

    private $validationErrors = [];

    public function __construct($company, $title, $file) {
        return $this->validate($company, $title, $file);
    }

    public function isGoodToGo()
    {
        return \count($this->validationErrors) ===0;
    }

    public function getValidationErrors()
    {
    return $this->validationErrors;
    }

    public function validate($company, $title, $file)
    {
        if ($company == null) {
            $this->validationErrors[] = "Company/User needed";

        }
        if ($title == null) {
            $this->validationErrors[] = "Title needed";
        }

        if ($file != null) {
            if ($this->fileNotPdf($file)) {
                $this->validationErrors[] = "Only .pdf file type allowed";
            }
        }

        if ($file == null) {
            $this->validationErrors[] = "File needed";
        }


        return $this->validationErrors;
    }


    public function fileNotPdf($file)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($finfo, $file);
        return (strcmp($fileType, "application/pdf"));
    }


}
