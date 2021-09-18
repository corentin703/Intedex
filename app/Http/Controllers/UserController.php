<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Repositories\UserRepositoryInterface;
use App\Models\Pokemon;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Maatwebsite\Excel\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->middleware("auth");

        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        Gate::authorize("is_admin");

        $users = $this->userRepository->getAllOrderedByNamePaginated(15);

        return view('users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Search in users
     *
     * @param Request $request
     * @return View
     */
    public function search(Request $request): View
    {
        $search_string = $request->get('search_string') ?? "";

        $users = $this->userRepository->getByNamePaginated($search_string, 15);

        // If search string matches exactly one username & result's count == 1
        if ($users->count() === 1 && strcasecmp($users[0]->name, $search_string) === 0) {
            return $this->show($users[0]);
        }

        return view('users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Display user profile
     *
     * @return View
     */
    public function show_profile(): View
    {
        $user = Auth::user();

        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(Request $request, User $user): View
    {
        if (!Gate::allows('is_admin') && !Gate::allows('is_current_user', $user)) {
            abort(403);
        }

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $can_change_user_role = false;

        if (!Gate::allows('is_current_user', $user)) {
            if (Gate::allows('is_admin')) {
                $can_change_user_role = true;
            } else {
                abort(403);
            }
        }

        $request->validate([
            'name' => ['string', 'max:255', 'unique:users,name,' . $user->id],
            'email' => ['string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['string', 'min:8', 'confirmed'],
        ]);

        $data = $request->toArray();

        if ($can_change_user_role) {
            if (isset($data['is_admin'])) {
                $user->is_admin = true;
            } else {
                $user->is_admin = false;
            }
        }

        $this->userRepository->update($user, $data);

        return redirect(route('users.show', $user->id));
    }

    /**
     * Set user's favorite pokemon
     *
     * @param Request $request
     * @param User $user
     * @param Pokemon $pokemon
     * @return RedirectResponse
     */
    public function set_favorite_pokemon(Request $request, User $user, Pokemon $pokemon): RedirectResponse
    {

        if (!Gate::allows('is_current_user', $user) && !Gate::allows('is_admin')) {
            abort(403);
        }

        if ($pokemon->id != null && !$user->pokemons->contains($pokemon)) {
            abort(403);
        } else {
            $this->userRepository->setFavoritePokemon($user, $pokemon);
        }

        return redirect(route('pokedex.index', $pokemon));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $is_current_user = Gate::allows('is_current_user', $user);

        if (!$is_current_user && !Gate::allows('is_admin')) {
            abort(403);
        }

        $this->userRepository->delete($user->id);

        if ($is_current_user) {
            Auth::logout();
        }

        return redirect(route('users.index', $user->id));
    }

    /**
     * Export data to excel file
     *
     * @return BinaryFileResponse
     */
    public function export(Excel $excel, UsersExport $usersExport): BinaryFileResponse
    {
        Gate::authorize("is_admin");

        return $excel->download($usersExport, 'intedex_users.xlsx');
    }
}
