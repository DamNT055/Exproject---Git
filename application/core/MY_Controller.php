<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter-HMVC
 *
 * @package    CodeIgniter-HMVC
 * @author     N3Cr0N (N3Cr0N@list.ru)
 * @copyright  2019 N3Cr0N
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @link       <URI> (description)
 * @version    GIT: $Id$
 * @since      Version 0.0.1
 * @filesource
 *
 */

class MY_Controller extends MX_Controller
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout,....
     */
    protected $data = array();

    /**
     * [__construct description]
     *
     * @method __construct
     */
    public function __construct()
    {
        // To inherit directly the attributes of the parent class.
        parent::__construct();

        // This function returns the main CodeIgniter object.
        // Normally, to call any of the available CodeIgniter object or pre defined library classes then you need to declare.
        $CI = &get_instance();

        // Copyright year calculation for the footer
        $begin = 2019;
        $end =  date("Y");
        $date = "$begin - $end";
        $this->load->model('Category_model', 'category');
        $this->load->library('cart');

        // Copyright
        $this->data['copyright'] = $date;
    }
    public function getView($view, $data = array())
    {   
        $data['view'] = $view;
        $data['category'] = $this->category->GetAll();
        #$this->cart->insert($dataInsert[0]);
        #$this->cart->update(array('rowid' => 'c4ca4238a0b923820dcc509a6f75849b', 'qty'   => 2 ));
        #$this->cart->destroy();
        $data['cart'] = $this->cart->contents();
        #$data['cart'] = array();
        #var_dump($data['cart']);die();
        return $this->load->view('layout', $data);
    }
}

// Backend controller
require_once(APPPATH . 'core/Backend_Controller.php');

// Frontend controller
require_once(APPPATH . 'core/Frontend_Controller.php');
