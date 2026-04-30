<?php
class ProfileController extends Controller
{
    public function index()
    {
        $this->view('profile/index', ['title' => 'Hồ sơ cá nhân']);
    }
}