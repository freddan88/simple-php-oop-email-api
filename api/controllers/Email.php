<?php

declare(strict_types=1);

class Email extends Response {

    private $httpStatuses;
    private $emailTo;
    private $senderName;
    private $senderEmail;
    private $emailSubject;
    private $emailMessage;

    public function __construct($data)
    {
        $configuration = parse_ini_file("config.ini", true);
        $this->httpStatuses = $configuration['http_codes'];

        $this->emailTo = trim(filter_var($data['emailTo'], FILTER_SANITIZE_EMAIL));
        $this->senderName = trim(filter_var($data['senderName'], FILTER_SANITIZE_STRING));
        $this->senderEmail = trim(filter_var($data['senderEmail'], FILTER_SANITIZE_EMAIL));
        $this->emailSubject = trim(filter_var($data['emailSubject'], FILTER_SANITIZE_STRING));
        $this->emailMessage = trim(filter_var($data['emailMessage'], FILTER_SANITIZE_STRING));
    }

    public function validate()
    {
        if (empty($this->emailTo)) $this->error($this->httpStatuses[503]);
        if (empty($this->senderName)) $this->senderName = 'Anonymous';
        if (empty($this->senderEmail)) $this->addFieldError('Email is missing', 'senderEmail');
        if (empty($this->emailSubject)) $this->addFieldError('Subject is missing', 'emailSubject');
        if (empty($this->emailMessage)) $this->addFieldError('Message is missing', 'emailMessage');

        if (!$this->fieldErrors['emailTo']) {
            if (!filter_var($this->emailTo, FILTER_VALIDATE_EMAIL)) $this->error($this->httpStatuses[503]);
        }

        if (!$this->fieldErrors['emailMessage']) {
            if (!filter_var($this->senderEmail, FILTER_VALIDATE_EMAIL)) $this->addFieldError("Not a valid email address", "senderEmail");
        }

        if (count($this->fieldErrors) > 0) {
            $this->getFieldErrors();
            return false;
        }

        return true;
    }

    public function send()
    {
        echo json_encode('sending email!');
        exit;
    }

}