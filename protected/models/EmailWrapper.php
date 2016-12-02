<?php
class EmailWrapper
{
	private $_sender;
	private $_receivers;
	private $_subject;
	private $_message;
	private $_emailType;
	private $_errors;
	private $_attachment;
	
	public function __construct()
	{
		// Load swift mailer library if needed
		if (!defined('SWIFT_LIB_DIRECTORY'))
		{
			$phpExcelPath = Yii::getPathOfAlias('ext.swiftMailer.lib');
			include($phpExcelPath . DIRECTORY_SEPARATOR . 'swift_required.php');
		}
		else
		{
			//echo 1;
		}
		
		// Set default attributes
		$this->_sender = array('jcipwebsite@gmail.com' => 'JCI Philippines');
		$this->_subject = 'JCI PH Notification';
		$this->_errors = array();
		$this->_emailType = 'text/html';
	}
		
	public function setMessage($message)
	{
		$this->_message = $message;
	}
		
	public function setReceivers($receivers)
	{
		$this->_receivers = $receivers;
	}
	
	public function setSender($sender)
	{
		$this->_sender = $sender;
	}
	
	public function setSubject($subject)
	{
		$this->_subject = $subject;
	}
	
	public function setAttachment($attachment)
	{
		$this->_attachment = $attachment;
	}
	
	public function getErrors()
	{
		return $this->_errors;
	}
	
	public function loadTemplate($template = null)
	{
		switch ($template)
		{
			case 'template1':
				$templateBody = 
					sprintf('
					<table cellpading="0" cellspacing="0" style="text-align:center; background-color:#ffffff; width:630px; margin:0 auto; font-family:arial, san-serif; font-size:13px;">
						<tr>
							<td style="padding:20px;color:#444444;vertical-align:top; text-align: left" colspan="2">
								%s
							</td>
						</tr>	
					</table>
					', $this->_message);
				break;
			default:
				$templateBody = 
					sprintf('
					<table cellpading="0" cellspacing="0" style="text-align:center; background-color:#ffffff; width:630px; margin:0 auto; font-family:arial, san-serif; font-size:13px;">
						<tr>
							<td style="padding:20px;color:#444444;vertical-align:top; text-align: left" colspan="2">
								%s
							</td>
						</tr>	
					</table>
					', $this->_message);
		}
		
		return $templateBody;
	}
	
	public function sendMessage($template = null)
	{
		$this->validateAttributes();
		
		if (empty($this->_errors))
		{
			$transport = Swift_SmtpTransport::newInstance('mail.jci.org.ph', 465, "ssl")
				->setUsername('quadrant@jci.org.ph')
				->setPassword('FTmz4QD)t!4T')
			;

			//$transport = Swift_SmtpTransport::newInstance('localhost', 25);
			$mailer = Swift_Mailer::newInstance($transport);
			
			if($this->_attachment == null)
			{
				$message = Swift_Message::newInstance()
				->setSubject($this->_subject)
				->setFrom(array('quadrant@jci.org.ph'=>'JCI Philippines'))
				->setTo($this->_receivers)
				->setBody($this->loadTemplate($template), $this->_emailType);
			}
			else
			{
				$message = Swift_Message::newInstance()
				->setSubject($this->_subject)
				->setFrom(array('quadrant@jci.org.ph'=>'JCI Philippines'))
				->setTo($this->_receivers)
				->setBody($this->loadTemplate($template), $this->_emailType)
				->attach($this->_attachment);
			}
				
			if ($mailer->send($message))
			{
				return true;
			}
			else
			{
				$this->_errors[] = 'Sorry but an error has occurred processing the email message';
				
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function validateAttributes()
	{
		if ($this->_receivers === null || empty($this->_receivers))
		{
			$this->_errors[] = 'Please set at least 1 receiver';
		}
		
		if ($this->_message === null)
		{
			$this->_errors[] = 'Please enter a message for the email';
		}
	}
}
?>