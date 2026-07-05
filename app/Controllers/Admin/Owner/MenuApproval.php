<?php

namespace App\Controllers\Admin\Owner;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class MenuApproval extends BaseController
{
    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    public function index()
    {
        $data['pendingMenus'] = $this->menuModel->getPendingMenus();
        return view('Owner/menu_approval/index', $data);
    }

    public function approve($id)
    {
        $this->menuModel->approveMenu($id, session()->get('admin_id'));
        return redirect()->to('/owner/menu-approval')->with('success', 'Menu berhasil disetujui.');
    }

    public function reject($id)
    {
        $reason = $this->request->getPost('reason');
        $this->menuModel->rejectMenu($id, session()->get('admin_id'), $reason);
        return redirect()->to('/owner/menu-approval')->with('success', 'Menu ditolak.');
    }
}