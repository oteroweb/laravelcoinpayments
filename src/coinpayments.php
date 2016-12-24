<?php
namespace oteroweb\LaravelCoinPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;


	require('./coinpayments.inc.php');
/**
 * Class CoinPayment
 */
class CoinPayment {
    /**
     * @var string
     */
    protected $public_key;
	
    /**
     * @var string
     */
    protected $private_key;
	
	
    public function __construct()
	{
		$this->private_key = config('bitcoinpayment.private_key');
		$this->public_key = config('bitcoinpayment.public_key');
    }
	
    /**
     * get the balance for the wallet
     *
     * @return array
     */
	public function getBalance()
	{
		
	}
	
    /**
     * Send Money
     *
	 * @param   string        $account
	 * @param   double        $amount
	 * @param   string        $descripion
	 * @param   string        $payment_id
	 *
     * @return array
     */
	public function sendMoney($account, $amount, $descripion = '', $payment_id = '')
	{
		
		
	}
	
    /**
     * Render form
     *
	 * @param   array        $data
	 *
     * @return \Illuminate\View\View
     */
	public static function render($data = [], $view = 'perfectmoney')
	{
		
		$view_data = [
			'PAYEE_ACCOUNT'			=> (isset($data['PAYEE_ACCOUNT']) ? $data['PAYEE_ACCOUNT'] : config('perfectmoney.marchant_id')),
		];
		
		// Status URL
		if(config('perfectmoney.status_url') || isset( $data['STATUS_URL'] ))
		{
			$view_data['STATUS_URL'] = (isset( $data['STATUS_URL']) ? $data['STATUS_URL'] : config('perfectmoney.status_url'));
		}
		// Custom view
		if(view()->exists('laravelcoinpayment::' . $view)){
			return view('laravelperfectmoney::' . $view, $view_data);
		}
		
		
		// Default view
		return view('laravelperfectmoney::perfectmoney', $view_data);
	}
	
	
    /**
     * This script demonstrates querying account history
	 * using PerfectMoney API interface.
     *
	 * @param   int        $start_day
	 * @param   int        $start_month
	 * @param   int        $end_year
	 * @param   int        $end_day
	 * @param   int        $end_month
	 * @param   int        $end_year
	 *
     * @return array
     */
	public function getHistory($start_day = null, $start_month = null, $start_year = null, $end_day = null, $end_month = null, $end_year = null, $data = [])
	{
		
		$start_day = ($start_day ? $start_day : Carbon::now()->subYear(1)->day);
		$start_month = ($start_month ? $start_month : Carbon::now()->subYear(1)->month);
		$start_year =  ($start_year ? $start_year : Carbon::now()->subYear(1)->year);
		$end_day = ($end_day ? $end_day : Carbon::now()->day);
		$end_month = ($end_month ? $end_month : Carbon::now()->month);
		$end_year = ($end_year ? $end_year : Carbon::now()->year);
		
		
		$url = 'https://perfectmoney.is/acct/historycsv.asp?startmonth=' . $start_month . '&startday=' . $start_day . '&startyear=' . $start_year . '&endmonth=' . $end_month . '&endday=' . $end_day . '&endyear=' . $end_year . '&AccountID=' . urlencode(trim($this->account_id)) . '&PassPhrase=' . urlencode(trim($this->passphrase));
		
		// Custom Filters
		if(isset($data['payment_id']))
		{
			$url .= '&payment_id=' . $data['payment_id'];
		}
		
		// Custom Filters
		if(isset($data['batchfilter']))
		{
			$url .= '&batchfilter=' . $data['batchfilter'];
		}
		
		if(isset($data['counterfilter']))
		{
			$url .= '&counterfilter=' . $data['counterfilter'];
		}
		
		if(isset($data['metalfilter']))
		{
			$url .= '&metalfilter=' . $data['metalfilter'];
		}
		
		if(isset($data['payment_id']))
		{
			$url .= '&payment_id=' . $data['payment_id'];
		}
		
		if(isset($data['oldsort']) && in_array(strtolower($data['oldsort']), ['tstamp', 'batch_num', 'metal_name', 'counteraccount_id', 'amount ']) )
		{
			$url .= '&oldsort=' . $data['oldsort'];
		}
		
		if(isset($data['paymentsmade']) && $data['paymentsmade'] == true)
		{
			$url .= '&paymentsmade=1';
		}
		
		if(isset($data['paymentsmade']) && $data['paymentsmade'] == true)
		{
			$url .= '&paymentsmade=1';
		}
		
		if(isset($data['paymentsreceived']) && $data['paymentsreceived'] == true)
		{
			$url .= '&paymentsreceived=1';
		}
		
		// Get data from the server
		$url = file_get_contents($url, false, stream_context_create($this->ssl_fix));
		if(!$url)
		{
		   return ['status' => 'error', 'message' => 'Connection error'];
		}
		
		if (substr($url, 0, 63) == 'Time,Type,Batch,Currency,Amount,Fee,Payer Account,Payee Account') { 
			
			$lines = explode("\n", $url);
			
			// Getting table names (Time,Type,Batch,Currency,Amount,Fee,Payer Account,Payee Account)
			$rows = explode(",", $lines[0]);
			
			$return_data = [];
			
			// Fetching history
			$return_data['history'] = [];
			for($i=1; $i < count($lines); $i++){
				
				// Skip empty lines
				if(empty($lines[$i]))
				{
					break;
				}
			
				// Split line into items
				$items = explode(',', $lines[$i]);
				
				// Get history items
				$history_line = [];
				foreach($items as $key => $value)
				{
					$history_line[str_replace(' ', '_', strtolower($rows[$key]))] = $value;
				}
				
				$return_data['history'][] = $history_line;
			
			}
			
			$return_data['status'] = 'success';
			
			return $return_data;
			
		}
		else
		{
			return ['status' => 'error', 'message' => $url];
		}
		
	}
	
	public function generateHash(Request $request)
	{
		
		$string = '';
		return strtoupper(md5($string));
	}

	// public function generateTransactionWithRedirect(Request $request)  {
	public function generateTransactionWithRedirect()  {

			$cps = new CoinPaymentsAPI();
			$cps->Setup($this->private_key, $this->public_key);
			$req = array(
				'amount' => 1,
				'currency1' => 'USD',
				'currency2' => 'BTC',
				'address' => '', // send to address in the Coin Acceptance Settings page
				'item_name' => 'Test Item/Order Description',
				'ipn_url' => 'https://yourserver.com/ipn_handler.php',
				'buyer_email' => 'oterolopez1990gmail.com'
			);
			// See https://www.coinpayments.net/apidoc-create-transaction for all of the available fields
					
			$result = $cps->CreateTransaction($req);
			if ($result['error'] == 'ok') {
				$le = php_sapi_name() == 'cli' ? "\n" : '<br />';
				print 'Transaction created with ID: '.$result['result']['txn_id'].$le;
				print 'Buyer should send '.sprintf('%.08f', $result['result']['amount']).' BTC'.$le;
				print 'Status URL: '.$result['result']['status_url'].$le;
			} else {
				print 'Error: '.$result['error']."\n";
			}
		}

}