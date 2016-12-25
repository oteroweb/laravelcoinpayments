<?php
namespace oteroweb\LaravelCoinPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

		require('coinpayments.inc.php');
use Auth;
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
		$this->private_key = config('coinpayment.PRIVATE_KEY');
		$this->public_key = config('coinpayment.PUBLIC_KEY');
    }
	
    /**
     * get the balance for the wallet
     *
     * @return array
     */
	public function getBalance() 	{}
	
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
	public function sendMoney($account, $amount, $descripion = '', $payment_id = '') {}
	
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
	{ }
	
	public function generateHash(Request $request)
	{}

	// public function generateTransactionWithRedirect(Request $request)  {
	public function generateTransactionWithRedirect(Request $request)  {

			$cps = new CoinPaymentsAPI();
			$cps->Setup($this->private_key, $this->public_key);
			$req = array(
				'amount' => $request->input('deposit'),
				'currency1' => 'USD',
				'currency2' => 'BTC',
				'address' => '', // send to address in the Coin Acceptance Settings page
				'item_name' => 'Test Item/Order Description',
				'ipn_url' => 'https://yourserver.com/ipn_handler.php',
				'buyer_email' => Auth::user()->email
			);
			// See https://www.coinpayments.net/apidoc-create-transaction for all of the available fields
			$result = $cps->CreateTransaction($req);
			header("Location: ".$result['result']['status_url']);
			// if ($result['error'] == 'ok') {
			// 	$le = php_sapi_name() == 'cli' ? "\n" : '<br />';
			// 	print 'Transaction created with ID: '.$result['result']['txn_id'].$le;
			// 	print 'Buyer should send '.sprintf('%.08f', $result['result']['amount']).' BTC'.$le;
			// 	print 'Status URL: '.$result['result']['status_url'].$le;
			// } else {
			// 	print 'Error: '.$result['error']."\n";
			// }
		}

}