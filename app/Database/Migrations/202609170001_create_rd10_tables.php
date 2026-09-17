<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateRd10Tables extends Migration{
public function up(){foreach(['users','materials','monthly_stock','daily_entries','weekly_notes','activity_logs','quantity_transactions'] as $t){} /* SQL schema.sql is the authoritative import for this build. */ }
public function down(){} }