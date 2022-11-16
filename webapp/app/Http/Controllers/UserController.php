<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use App\Http\Controllers\Redirect;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UserController extends AppBaseController
{
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function index(Request $request)
    {
        return view('users.show')->with('user', Auth::user());
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $users = $this->userRepository->all();

        return view('users.index')->with('users', $users);
    }

    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    public function edit($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        if($user->id != Auth::id()) {
            return view('users.show')->with('user', Auth::user());
        }

        return view('users.edit')->with('user', $user);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255'
        ]);

        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        if($request->image != null) {
            $imageName = 'user-' . $id . '.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('img/users/'), $imageName);
    
            $request->merge(['img' => $imageName]);
        }
        $user = $this->userRepository->update(array_filter($request->all()), $id);

        Flash::success('User updated successfully.');

        return redirect(route('users.show', $user));
    }

    public function destroy($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('users.index'));
    }
}
