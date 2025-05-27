<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Traits\SupportTicketManager;

class AgentTicketController extends Controller
{
    use SupportTicketManager;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'master';
        $this->redirectLink = 'agent.ticket.view';
        $this->userType     = 'agent';
        $this->column       = 'agent_id';
        $this->user = authAgent();
    }
}
