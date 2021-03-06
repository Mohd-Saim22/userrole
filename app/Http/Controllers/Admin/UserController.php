<?php

namespace App\Http\Controllers\Admin;

use \Exception;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View as IlluminateView;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class UserController extends Controller
{
    /**
     * User Repository Property.
     *
     * @var string
     */
    protected $userRepo;

    /**
     * Create a new UserController instance.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  UserRepository $userRepo
     * @return void
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the Users.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @throws  AuthorizationException
     * @return  IlluminateView
     */
    public function index(): IlluminateView
    {
        return ViewFacade::make('admin.access.users.index',$this->userRepo->showRecords());
    }

    /**
     * Show the form for creating a new User.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @throws  AuthorizationException
     * @return  IlluminateView
     */
    public function create(): IlluminateView
    {
        return ViewFacade::make('admin.access.users.create',$this->userRepo->createRecord());
    }

    /**
     * Store a newly created User in storage.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   UserStoreRequest  $request
     * @throws  AuthorizationException
     * @return  RedirectResponse
     */
    public function store( UserStoreRequest $request): RedirectResponse
    {
        $this->userRepo->storeRecord($request);       
        return Redirect::route('admin.access.users.index')
                        ->with( 'success', 'User Created Successfully');
    }

    /**
     * Display the specified User.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   User  $user
     * @throws  ModelNotFoundException
     * @throws  AuthorizationException
     * @return  IlluminateView
     */
    public function show(User $user): IlluminateView
    {
        return ViewFacade::make('admin.access.users.show', $this->userRepo->showRecord($user));
    }

    /**
     * Show the form for editing the specified User.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   User  $user
     * @throws  ModelNotFoundException
     * @throws  AuthorizationException
     * @return  IlluminateView
     */
    public function edit(User $user): IlluminateView
    {
        return ViewFacade::make('admin.access.users.edit', $this->userRepo->editRecord($user));
    }

    /**
     * Update the specified User in Database.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   UserUpdateRequest  $request
     * @param   User  $user
     * @throws  AuthorizationException
     * @return  RedirectResponse
     */
    public function update( UserUpdateRequest $request, User $user): RedirectResponse
    {
        $this->userRepo->updateRecord($request,$user);

        return Redirect::route('admin.access.users.index')
                        ->with('success', 'User Updated Successfully');
    }

    /**
     * Remove the specified User from Database.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @throws  Exception
     * @throws  MethodNotAllowedHttpException
     * @param   User  $user
     * @return  RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->userRepo->removeRecord($user);

        return Redirect::route('admin.access.users.index')
                        ->with('success', 'User Deleted Successfully');
    }
}
