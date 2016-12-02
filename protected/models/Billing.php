<?php

/**
 * This is the model class for table "{{billing}}".
 *
 * The followings are the available columns in table '{{billing}}':
 * @property integer $id
 * @property integer $event_attendees_id
 * @property double $price
 * @property string $date_created
 */
class Billing extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{billing}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_attendees_id, price, date_created', 'required'),
			array('event_attendees_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_attendees_id, price, date_created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'event_attendees_id' => 'Event Attendees',
			'price' => 'Price',
			'date_created' => 'Date Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('event_attendees_id',$this->event_attendees_id);
		$criteria->compare('price',$this->price);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Billing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/*public function createBillingStatementPDF($event_attendee_id){
			//require_once('C:\xampp\htdocs\JCI\protected\extensions\MYPDF.php');
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			spl_autoload_register(array('YiiBase','autoload'));

			$event_attendee = EventAttendees::model()->findByPk($event_attendee_id);
			$user = User::model()->find('account_id = '.$event_attendee->account_id);
			$event = Event::model()->findByPk($event_attendee->event_id);
			$billing = Event::model()->findByPk($event_attendee->event_id);
			$hostchapter = Chapter::model()->findByPk($event->host_chapter_id);
			$year = date("Y");
			$event_name = ucwords(strtolower($event->name));
			$paymentschemes = EventPS::model()->findAll('event_id = '.$event->id)
			$bank_details = "";

			foreach($paymentschemes as $ps)
			{
				$bank = PaymentSchemes::model()->findByPk($ps->payment_scheme_id);

				$bank_details += $bank->bank_details." - ".$bank->bank_account_no."<br />";
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
			$details = $billingstatement->bank_details;
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
				 $bank_details
				 ."<br />
				  * Note: Please settle your payment on or before the date of the event.
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
				$pdf->Output('/home/web1dev2015/public_html/mod02/pdfs/'.$event_attendee_id.'_Billing_Statement.pdf', 'F');
				//Yii::app()->end();
				//$this->redirect('/account/register');
		 
		} */
}
