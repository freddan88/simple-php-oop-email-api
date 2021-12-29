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

    private function getDatetimeNow()
    {
        $tz_object = new DateTimeZone('Europe/Stockholm');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime->format('Y-m-d H:i');
    }

    public function validate()
    {
        if (empty($this->emailTo)) $this->error($this->httpStatuses[503]);
        if (empty($this->senderName)) $this->senderName = 'Anonymous';
        if (empty($this->senderEmail)) $this->addFieldError('Email is missing', 'senderEmail');
        if (empty($this->emailSubject)) $this->addFieldError('Subject is missing', 'emailSubject');
        if (empty($this->emailMessage)) $this->addFieldError('Message is missing', 'emailMessage');

        if (!array_key_exists('emailTo', $this->fieldErrors)) {
            if (!filter_var($this->emailTo, FILTER_VALIDATE_EMAIL)) $this->error($this->httpStatuses[503]);
        }

        if (!array_key_exists('senderEmail', $this->fieldErrors)) {
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
        $headers = "From: $this->senderName <$this->senderEmail>\r\n" .
        "MIME-Version: 1.0" . "\r\n" .
        "Content-type: text/html; charset=UTF-8" . "\r\n";
        $message = nl2br(wordwrap($this->emailMessage, 80));
        $date = $this->getDatetimeNow();

        $body = "
        <html>
        <body>
        From: $this->senderName <br/>
        Mail: <a href='mailto:$this->senderEmail'>$this->senderEmail</a><br/>
        Date: $date<br/>
        -----
        <br/>
        $message
        </body>
        </html>
        ";

        $email_status = mail($this->emailTo, $this->emailSubject, $body, $headers);

        if (!$email_status) $this->customResponse('Email failed to send', false);

        $this->customResponse('Email sent successfully', true);
    }

}