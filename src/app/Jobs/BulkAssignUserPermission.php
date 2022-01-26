<?php

namespace App\Jobs;

use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BulkAssignUserPermission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $idUsers;
    protected array $permissions;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $idUsers, array $permissions)
    {
        $this->idUsers       = $idUsers;
        $this->permissions   = $permissions;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserService $userService)
    {
        $userService->bulkAssignUserPermission($this->idUsers, $this->permissions);
    }
}
