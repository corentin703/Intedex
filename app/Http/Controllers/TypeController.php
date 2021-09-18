<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TypeRepositoryInterface;
use App\Http\Requests\TypeDeleteRequest;
use App\Http\Requests\TypeStoreRequest;
use App\Http\Requests\TypeUpdateRequest;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class TypeController extends Controller
{
    private TypeRepositoryInterface $typeRepository;

    /**
     * @param TypeRepositoryInterface $typeRepository
     */
    public function __construct(TypeRepositoryInterface $typeRepository)
    {
        $this->middleware("auth");
        $this->middleware("verified");

        $this->typeRepository = $typeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        Gate::authorize("is_admin");

        $types = $this->typeRepository->getAllOrderedByName();

        return view('types.index', [
           'types' => $types,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        Gate::authorize("is_admin");

        return view('types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TypeStoreRequest $request
     * @return RedirectResponse
     */
    public function store(TypeStoreRequest $request): RedirectResponse
    {
        $this->typeRepository->create($request->toArray());

        return redirect(route('types.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Type $type
     * @return View
     */
    public function show(Type $type): View
    {
        Gate::authorize("is_admin");

        return view('types.show', [
            'type' => $type,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Type $type
     * @return View
     */
    public function edit(Type $type): View
    {
        Gate::authorize("is_admin");

        return view('types.edit', [
            'type' => $type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TypeUpdateRequest $request
     * @param Type $type
     * @return RedirectResponse
     */
    public function update(TypeUpdateRequest $request, Type $type): RedirectResponse
    {
        $this->typeRepository->update($type, $request->toArray());

        return redirect(route('types.show', $type->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TypeDeleteRequest $request
     * @param Type $type
     * @return RedirectResponse
     */
    public function destroy(TypeDeleteRequest $request, Type $type): RedirectResponse
    {
        $this->typeRepository->delete($type->id);

        return redirect(route('types.index'));
    }
}
