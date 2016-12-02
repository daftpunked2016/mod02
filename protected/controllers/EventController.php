<?php

class EventController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/userPanel';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index', 'print', 'viewbspdf'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','view', 'eventregister','print','uploadpayment', 'configeventregister', 'transactions', 'viewbspdf','resendPayment', 'deletePayment', 'updatePayment', 'listunpaids'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($event_id)
	{
		$account_id = Yii::app()->user->id;
		$event = Event::model()->findByPk($event_id);
		$eventpricing = $event->event_pricing;
		$event_ps = $event->event_ps;
		$event_attendee = EventAttendees::model()->find("account_id = ".$account_id." AND event_id = ".$event_id);

		if($account_id != null && $event != null)
		{
			if($eventpricing->pricing_type == 3) // if pricing_type = Packages -> determine packages
				{
					$package_type = $this->determinePackagePricing($eventpricing);
				}


			$this->render('view',array(
				'event'=>$event,
				'eventpricing' => $eventpricing,
				'event_ps' => $event_ps,
				'event_attendee' => $event_attendee,
				'package_type' => $package_type,
			));
		}
		else
			$this->redirect(array('site/login'));

	}

	/*
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$account_id = Yii::app()->user->id;

		if($account_id != null)
		{
			$events = Event::model()->findAll("status_id = 1");
				
			$eventsDP = new CArrayDataProvider($events, array(
					'pagination' => array(
						'pageSize' => 10,
					)
			));

			$this->render('index',array(
				'eventsDP'=>$eventsDP,
				'events'=>$events,
			));
		}
		else
			$this->redirect(array('site/login'));

	}

	public function actionTransactions()
	{
		$account_id = Yii::app()->user->id;

		if($account_id != null)
		{
			$event_attendees = EventAttendees::model()->findAll("account_id = ".$account_id);
			$payments = Payments::model()->findAll(array('condition' => 'account_id = '.$account_id.' AND status_id = 1'));
				
			$eventAttendeeDP = new CArrayDataProvider($event_attendees, array(
					'pagination' => array(
						'pageSize' => 10,
					)
			));

			$this->render('transactions',array(
				'eventAttendeeDP'=>$eventAttendeeDP,
				'event_attendees'=>$event_attendees,
				'payments' => $payments
			));
		}
		else
			$this->redirect(array('site/login'));

	}

	/**
	 * Performs the AJAX validation.
	 * @param Event $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='event-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionConfigEventRegister($event_id)
	{
		$account_id = Yii::app()->user->id;
		$event = Event::model()->findByPk($event_id);
		$eventpricing = $event->event_pricing;
		$event_ps = $event->event_ps;
		$event_attendee = EventAttendees::model()->find("event_id = ".$event_id." AND account_id = ".$account_id);

		if($account_id != null && $event != null)
		{
			if($event_attendee == null)
			{
				if($eventpricing->pricing_type == 3) // if pricing_type = Packages -> determine packages
				{
					$package_type = $this->determinePackagePricing($eventpricing);
				}


				if(isset($_POST['register'])) // if registration submitted
				{
					$this->redirect(array('event/eventregister', 'event_id' => $event_id, 'package_type' => $package_type));
				}

				$this->render('config',array(
					'event'=>$event,
					'eventpricing' => $eventpricing,
					'event_ps' => $event_ps,
					'package_type' => $package_type,
				));
			}
			else
			{	
				Yii::app()->user->setFlash('error', 'You\'re already registered for the selected event!');
				$this->redirect(array('event/index'));
			}
		}
		else
			$this->redirect(array('site/login'));
	}

	public function actionEventRegister($event_id, $package_type = 0)
	{
		$account_id = Yii::app()->user->id;
		$price = '';

		if($account_id != null)
		{
			$validateAttendee = EventAttendees::model()->validateAttendee($event_id, $account_id);

			if($validateAttendee)
			{
				$event = Event::model()->findByPk($event_id);
				$eventpricing = $event->event_pricing;

				//DETERMINE PRICING
				if($eventpricing->pricing_type == 1)
				{
					$price = $eventpricing->early_bird_price;
				}
				elseif($eventpricing->pricing_type == 2) //FIXED RATE
				{
					$price = $eventpricing->regular_price;
				}
				elseif($eventpricing->pricing_type == 3) //PACKAGES
				{
					//DETERMINE PACKAGE & PRICING
					if($package_type == 1)
						$price = $eventpricing->early_bird_price; //early bird rate
					elseif($package_type == 2)
						$price = $eventpricing->regular_price; //regular rate
					elseif($package_type == 3)
						$price = $eventpricing->onsite_price; //onsite rate
				}

				if($price != '')
				{
					//REGISTER ATTENDEE TO EVENT & CREATE BILLING STATEMENT
					$registerAttendee = EventAttendees::model()->eventRegistration($account_id, $event_id, $price, $eventpricing->pricing_type); //returns event_attendee_id 
					

					if($registerAttendee != 0) 
					{
						//VALIDATE
						$checkRegistration = EventAttendees::model()->checkRegistration($registerAttendee); //returns boolean value

						if($checkRegistration)
						{
							$this->printBillingStatement($registerAttendee);
							Event::model()->setEmailProp(1, $event->host_account_id, $event->id); // EMAIL NOTIF for HOST

							if($eventpricing->pricing_type != 1)
								Event::model()->setEmailProp(7, $account_id, $event->id); // EMAIL NOTIF for USER 
							
							Yii::app()->user->setFlash('success', 'You have successfully registered for the event! Please use the Billing Statement that was sent to your email, as a reference for paying.');
							$this->redirect(array('event/view', 'event_id'=>$event_id));
						} 
						else
						{
							Yii::app()->user->setFlash('error', 'Registration Failed! Please try again later.');
							$this->redirect(array('event/view', 'event_id'=>$event_id));
						}
					}
					else
					{
						Yii::app()->user->setFlash('error', 'Registration Failed! Please try again later.');
						$this->redirect(array('event/view', 'event_id'=>$event_id));
					}
				}
				else
				{
					Yii::app()->user->setFlash('error', 'Registration Failed! Invalid Event.');
					$this->redirect(array('event/view', 'event_id'=>$event_id));
				}
			}
			else
			{
				Yii::app()->user->setFlash('error', 'You\'re already registered for the selected event!');
				$this->redirect(array('event/index'));
			}

		}
		else
			$this->redirect(array('site/login'));
	} 

	public function actionUploadPayment($event_id)
	{
		$event = Event::model()->findByPk($event_id);
		$account = Account::model()->findByPk(Yii::app()->user->id);
		$event_attendee = EventAttendees::model()->find("account_id = ".$account->id." AND event_id = ".$event->id);

		if($event!= null && $account != null)
		{
			if($event_attendee != null)
			{ 
				$billing = Billing::model()->find("event_attendees_id = ".$event_attendee->id);
				$eventpricing = EventPricing::model()->find("event_id = ".$event_id." AND status_id = 1");

				$package_type = $this->determinePackagePricing($eventpricing);

				
				if($eventpricing->pricing_type == 3)
				{
					if($package_type == 1)
						$currentprice = $eventpricing->early_bird_price;
					elseif($package_type == 2)
						$currentprice = $eventpricing->regular_price;
					elseif($package_type == 3)
						$currentprice = $eventpricing->onsite_price;
				}
				else
					$currentprice = $eventpricing->regular_price;

				if($currentprice != $billing->price)
				{
					Yii::app()->user->setFlash('error', 
						'<strong>Note:</strong> The <strong><i>Expected Amount</i></strong> has been updated and it doesn\'t correspond to your current Billing Statement. 
						Reason for this could be: <i>event pricing has been changed or previous package pricing had reached its date limit</i>. 
						Please contact the JCI Headquarters or your Chapter President if there\'s an issue in your payment with this update.');
				}


				if(isset($_POST['bank_branch']))
				{
					if($_POST['amount'] >= $billing->price)
					{
						$payment = new Payments;
						$fileupload = new Fileupload;
						$filerelation = new Filerelation;

						$payment->bank_branch = $_POST['bank_branch'];
						$payment->date = $_POST['date'];
						$payment->time = $_POST['time'];
						$payment->amount = $_POST['amount'];
						$payment->event_id = $event->id;
						$payment->account_id = $account->id;
						$payment->event_attendees_id = $event_attendee->id;
						$payment->status_id = 2;
						$payment->date_uploaded =  date('Y-m-d');

						//FILE UPLOAD RENAMING
						$name       = $_FILES['receipt']['name'];
						$ext        = pathinfo($name, PATHINFO_EXTENSION);
						$currentDate = date('Ymdhis');
						$newName = 'JCIPH-PA-'.$currentDate.''.$account->id.'.'.$ext;

						$fileupload->poster_id= $account->id;			
						$avatar =  $newName;
						$fileupload->filename = $avatar;
						$target_path = "payment_uploads/";
						$target_path = $target_path . $avatar;

						$connection = Yii::app()->db;
						$transaction = $connection->beginTransaction();
									
						try
						{
							if ($fileupload->save())
							{
								
								$payment->payment_avatar = $fileupload->id;
								move_uploaded_file($_FILES["receipt"]["tmp_name"], $target_path);
								
								if ($payment->save())
								{
									$filerelation->fileupload_id = $fileupload->id;
									$filerelation->relationship_id = 4; //4 for Payments
																		 
									if ($filerelation->save())
									{
										$transaction->commit();
										$changeStatus = EventAttendees::model()->updateStatusToPending($event_attendee->id);
										
										if($changeStatus)
										{
											Event::model()->setEmailProp(2, $event->host_account_id, $event->id); // EMAIL NOTIF
											Yii::app()->user->setFlash('success', 'You have successfully uploaded a payment for an event.');
											$this->redirect(array('event/transactions')); 
										}
									}
									else
										print_r($filerelation->getErrors());exit;	
								}
								else
									print_r($payment->getErrors());exit;
							}
							else
								print_r($fileupload->getErrors());exit;
						}
						catch (Exception $e)
						{
							$transaction->rollback();
							Yii::app()->user->setFlash('error', 'An error occured while trying to update the account! Please try again later.');
							$this->redirect('profile');
						}
					}
					else
						Yii::app()->user->setFlash('error', 'Amount Paid must be equal or higher than the expected amount!');
				}

				$this->render('uploadpayment',array(
					'event'=>$event,
					'billing'=>$billing,
					'currentprice' => $currentprice,
				));
			}
			else
			{
				Yii::app()->user->setFlash('error', 'You must register for the event first!');
				$this->redirect(array('index'));
			}
		}
		else
			$this->redirect(array('site/login'));	

	} 

	//for Rejected Payments
	public function actionResendPayment($event_attendees_id)
	{
		$event_attendee = EventAttendees::model()->findByPk($event_attendees_id);
		$payment = Payments::model()->find('event_attendees_id = '.$event_attendees_id);

		$event_attendee->payment_status = 2;
		$payment->status_id = 2;

		$valid = $event_attendee->validate();
		$valid = $payment->validate() && $valid;

		if ($valid)
		{	
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();

			if($event_attendee->save(false))
			{
				if($payment->save(false))
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Your payment has been successfully resent.');
				}
				else
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'An error occured while trying to resend your payment! Please try again later.');
				}
			}
			else
			{
				$transaction->rollback();
				Yii::app()->user->setFlash('error', 'An error occured while trying to resend your payment! Please try again later.');
			}		
		}
		else
			Yii::app()->user->setFlash('error', 'An error occured while trying to resend your payment! Please try again later.');

		$this->redirect(array('event/transactions'));

	}


	//for Rejected Payments
	public function actionDeletePayment($event_attendees_id)
	{
		$event_attendee = EventAttendees::model()->findByPk($event_attendees_id);
		$payment = Payments::model()->find('event_attendees_id = '.$event_attendees_id);

		$event_attendee->payment_status = 3;

		$valid = $event_attendee->validate();

		if ($valid)
		{	
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();

			if($event_attendee->save(false))
			{
				if($payment->delete())
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Your payment has been successfully deleted.');
				}
				else
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'An error occured while trying to delete your payment! Please try again later.');
				}
			}
			else
			{
				$transaction->rollback();
				Yii::app()->user->setFlash('error', 'An error occured while trying to delete your payment! Please try again later.');
			}		
		}
		else
			Yii::app()->user->setFlash('error', 'An error occured while trying to delete your payment! Please try again later.');

		$this->redirect(array('event/transactions'));

	}


	public function actionUpdatePayment($event_attendees_id, $resend = 0)
	{
		$payment = Payments::model()->find('event_attendees_id = '.$event_attendees_id);
		$event = Event::model()->findByPk($payment->event_id);
		$billing = Billing::model()->find("event_attendees_id = ".$event_attendees_id);
		$account = Account::model()->findByPk(Yii::app()->user->id);
		$eventpricing = EventPricing::model()->find("event_id = ".$event->id." AND status_id = 1");
		$event_attendee = EventAttendees::model()->findByPk($event_attendees_id);

		$package_type = $this->determinePackagePricing($eventpricing);
		
		if($eventpricing->pricing_type == 3)
		{
			if($package_type == 1)
				$currentprice = $eventpricing->early_bird_price;
			elseif($package_type == 2)
				$currentprice = $eventpricing->regular_price;
			elseif($package_type == 3)
				$currentprice = $eventpricing->onsite_price;
		}
		else
			$currentprice = $eventpricing->regular_price;
		
		if($currentprice != $billing->price)
				{
					Yii::app()->user->setFlash('error', 
						'<strong>Note:</strong> The <strong><i>Expected Amount</i></strong> has been updated and it doesn\'t correspond to your current Billing Statement. 
						Reason for this could be: <i>event pricing has been changed or previous package pricing had reached its date limit</i>. 
						Please contact the JCI Headquarters or your Chapter President if there\'s an issue in your payment with this update.');
				}

		if(isset($_POST['update']))
		{
			if($_POST['date'] != null || $_POST['date'] !== '')
				$payment->date = $_POST['date'];
			
			$payment->bank_branch = $_POST['bank_branch'];
			$payment->time = $_POST['time'];
			$payment->amount = $_POST['amount'];

			if($resend == 1) //if Resend Payment
			{
				$event_attendee->payment_status = 2;
				$payment->status_id = 2;
			}

			$valid = $payment->validate();

			if ($valid)
			{	
				$connection = Yii::app()->db;
				$transaction = $connection->beginTransaction();

				if($_FILES['receipt']['name'] != null) //if new Receipt Photo will be uploaded 
					{
						$fileupload = new Fileupload;
						$filerelation = new Filerelation;

						//FILE UPLOAD RENAMING
						$name       = $_FILES['receipt']['name'];
						$ext        = pathinfo($name, PATHINFO_EXTENSION);
						$currentDate = date('Ymdhis');
						$newName = 'JCIPH-PA-'.$currentDate.''.$account->id.'.'.$ext;

						$fileupload->poster_id = $account->id;			
						$avatar =  $newName;
						$fileupload->filename = $avatar;
						$target_path = "payment_uploads/";
						$target_path = $target_path . $avatar;

						if ($fileupload->save())
						{
							$payment->payment_avatar = $fileupload->id;
							move_uploaded_file($_FILES["receipt"]["tmp_name"], $target_path);
							$filerelation->fileupload_id = $fileupload->id;
							$filerelation->relationship_id = 4; //4 for Payments
							$filerelation->save();
						}
					}

				if($payment->save(false))
				{
					if($event_attendee->save(false))
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Your payment has been successfully updated.');

						if($resend == 1)
						{
							Event::model()->setEmailProp(3, $event->host_account_id, $event->id); // EMAIL NOTIF
							$this->redirect('transactions');
						}
					}
				}
				else
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'An error occured while trying to update your payment! Please try again later.');
				}	
			}
			else
				Yii::app()->user->setFlash('error', 'An error occured while trying to update your payment! Please try again later.');
		}

		$this->render('updatepayment',array(
				'event'=>$event,
				'billing'=>$billing,
				'payment'=>$payment,
				'currentprice'=>$currentprice,
				'resend' => $resend,
			));

	}

	public function actionListUnpaids() //Empty Uploads
	{
		$event_list = array();
		$account = Account::model()->findByPk(Yii::app()->user->id);
		$event_attendee = EventAttendees::model()->findAll('account_id = '.$account->id.' AND payment_status = 3');

		foreach($event_attendee as $a)
		{
			$event = Event::model()->find('id = '.$a->event_id.' AND status_id = 1');

			if($event != null)
				$event_list[] = $a;
		}

		if($account != null)
		{
			if(isset($_POST['event']))
			{
				$this->redirect(array('event/uploadpayment', 'event_id' => $_POST['event']));
			}

			$this->render('listunpaids',array(
					'event_list'=>$event_list,
			));
		}
		else
			$this->redirect(array('site/login'));

	}

	public function printBillingStatement($event_attendee_id){
			//require_once($_SERVER['SERVER_NAME'].Yii::app()->baseUrl.'/protected/extensions/MYPDF.php'); 
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			spl_autoload_register(array('YiiBase','autoload'));

			$event_attendee = EventAttendees::model()->findByPk($event_attendee_id);	
			$user = User::model()->find('account_id = '.$event_attendee->account_id);
			$event = Event::model()->findByPk($event_attendee->event_id);
			$billing = Billing::model()->find('event_attendees_id = '.$event_attendee->id); 
			$hostchapter = Chapter::model()->findByPk($event->host_chapter_id);
			$year = date("Y");
			$event_name = ucwords(strtolower($event->name));
			$paymentschemes = EventPS::model()->findAll('event_id = '.$event->id);
			$bank_details = "";

	

			foreach($paymentschemes as $ps)
			{
				$bank = PaymentScheme::model()->findByPk($ps->payment_scheme_id);

				$bank_details = $bank_details." ".$bank->bank_details." - ".$bank->bank_account_no."<br />";
			}
	 		

			// set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("JCI Philippines ".$year);                
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $event_name, "Hosted by: ".$hostchapter->chapter);
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetTextColor("Black"); 
			$pdf->AddPage();
			
			

			$reg_no = $event_attendee->id;
			$fullname = ucwords(strtolower($user->lastname)).", ".ucwords(strtolower($user->firstname))." ".ucwords(strtolower($user->middlename));
			$date = $billing->date_created;
			$grandtotal = $billing->price;
			//Write the html
			$html = "<div style='margin-bottom:15px;'><B>Billing Statement Information: </B></div><br />
				NAME:  ".$fullname."<br>REG. NO: ".$reg_no."<br>DATE REGISTERED: ".$date. 
				"<div style='margin-bottom:15px;'><B><br /> 
				ITEM DESCRIPTION</B>
				<br />Event Ticket for: <br /><B><I>".$fullname."</I></B><br /><br />
				<B>AMOUNT</B><br />Php. ".$grandtotal."
				<br /><br />
				<B>Grand Total: </b> Php ".$grandtotal."
				 
				 <br><br><B>Bank Account Details: </b><br/>".
				 $bank_details."<br />
				  * <b>Notes:</b> - Please settle your payment on or before the date of the event.<br />
				  - Always monitor the event for updates especially before settling your payment. The <i>Total Amount</i> could change depending upon pricing updates, especially for Packages Pricing due to its date limit. (eg. Early Bird Promo, Regular, Onsite). 
				 </div>";
				

			//Convert the Html to a pdf document
			$pdf->writeHTML($html, true, false, true, false, '');
	 
			$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)'); //TODO:you can change this Header information according to your need.Also create a Dynamic Header.
	 
			// data loading
			$data = $pdf->LoadData(Yii::getPathOfAlias('ext.tcpdf').DIRECTORY_SEPARATOR.'table_data_demo.txt'); //This is the example to load a data from text file. You can change here code to generate a Data Set from your model active Records. Any how we need a Data set Array here.
			// print colored table
			

			
			// set style for barcode
			$style = array(
				'border' => false,
				'vpadding' => 'auto',
				'hpadding' => 'auto',
				'fgcolor' => array(0,0,0),
				'bgcolor' => false, //array(255,255,255)
				'module_width' => 1, // width of a single module in points
				'module_height' => 1 // height of a single module in points
			);

				
				$pdf->Cell(0, 20,"...........................................................................................................................................................");
				$pdf->Cell(0, 30,"                    * This serves as your official receipt.");
				// reset pointer to the last page
				$pdf->lastPage();
		 
				//Close and output PDF document
				ob_end_clean();
				// print_r(Yii::getPathOfAlias('ext.swiftMailer.lib'));
				// exit; 
				$pdf->Output('/home/quadrant/public_html/mod02/pdfs/'.$event_attendee_id.'_Billing_Statement.pdf', 'F');
				//Yii::app()->end();
				//$this->redirect('/account/register');
		 
		}

	public function actionViewBSPDF($event_id, $account_id = 0)
	{
		if($account_id == 0)
			$account_id = Yii::app()->user->id;

		$account = Account::model()->findByPk($account_id);
		$event_attendee = EventAttendees::model()->find("account_id = ".$account_id." AND event_id = ".$event_id);
		
		if($account != null)
		{
			 header("Location: ".Yii::app()->baseUrl."/pdfs/".$event_attendee->id."_Billing_Statement.pdf");
		}
		else
		{
			Yii::app()->user->setFlash('error','There\'s an error in showing your billing statement. Please try again later.');
			$this->redirect(array('site/index')); 
		}
	}


	public function determinePackagePricing(EventPricing $eventpricing)
	{
		//$eventpricing = EventPricing::model()->findByPk($event_pricing_id);

		if($eventpricing->pricing_type == 3) // if pricing_type = Packages -> determine packages
		{
			$package_type = 0;
			$date_now = strtotime(date('Y-m-d'));
			$eb_begin_date = strtotime($eventpricing->eb_begin_date);
			$eb_end_date = strtotime($eventpricing->eb_end_date);
			$regular_begin_date = strtotime($eventpricing->regular_begin_date);
			$regular_end_date = strtotime($eventpricing->regular_end_date);
			$onsite_begin_date = strtotime($eventpricing->onsite_begin_date);
			$onsite_end_date = strtotime($eventpricing->onsite_end_date);

			if(($date_now <= $eb_begin_date || $date_now >= $eb_begin_date) && $date_now<=$eb_end_date && $date_now < $regular_begin_date) //early bird
				$package_type = 1;
			elseif(($date_now > $eb_end_date || $date_now >= $regular_begin_date) && $date_now<=$regular_end_date && $date_now < $onsite_begin_date) //reg
				$package_type = 2;	
			elseif(($date_now > $regular_end_date || $date_now >= $onsite_begin_date) && ($date_now<=$onsite_end_date || $date_now > $onsite_end_date)) //onsite
				$package_type = 3;

			return $package_type;
		}
		else
			return 0;
	}
}