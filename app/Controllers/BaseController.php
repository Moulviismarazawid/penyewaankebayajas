<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class BaseController extends Controller
{
    // urutan bebas, tapi rapikan saja
    protected $helpers = ['url', 'form', 'text', 'security', 'order'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Cukup panggil sekali, CI4 idempotent; nggak perlu if session_status
        session();
    }
}
