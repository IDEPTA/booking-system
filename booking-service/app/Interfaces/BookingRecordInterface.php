<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface BookingRecordInterface
{
    public function index();

    public function show(int $id);

    public function create(Request|array $request);

    public function update(Request $request, int $id);

    public function delete(int $id);

    public function cancelReservation(int $id);

    public function validated(Request $request);
}