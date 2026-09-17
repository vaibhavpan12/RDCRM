<?php
function current_user(){return session()->get('user')??null;}
function is_admin(){return (session()->get('user')['role']??null)==='admin';}