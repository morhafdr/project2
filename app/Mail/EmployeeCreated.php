<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $plainPassword;  // Add this property

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Employee $employee, $plainPassword)
    {
        $this->employee = $employee;
        $this->plainPassword = $plainPassword;  // Store the plain-text password
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.employee_created')
            ->subject('Welcome to the Company!')
            ->with([
                'firstName' => $this->employee->user->first_name,
                'lastName' => $this->employee->user->last_name,
                'email' => $this->employee->user->email,
                'phone' => $this->employee->user->phone,
                'office' => $this->employee->office,
                'joinDate' => $this->employee->join_date,
                'password' => $this->plainPassword,  // Use the plain-text password here
            ]);
    }
}
