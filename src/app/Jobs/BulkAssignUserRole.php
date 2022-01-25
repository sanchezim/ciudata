<?php

namespace App\Jobs;

use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BulkAssignUserRole implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $idUsers;
    protected array $roles;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $idUsers, array $roles)
    {
        $this->idUsers = $idUsers;
        $this->roles   = $roles;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserService $userService)
    {
        $userService->bulkAssignUserRole($this->idUsers, $this->roles);
    }
}
