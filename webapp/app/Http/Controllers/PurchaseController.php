<?php

namespace App\Http\Controllers;

use App\Repositories\PurchaseRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PurchaseController extends AppBaseController
{
    private $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepo)
    {
        $this->purchaseRepository = $purchaseRepo;
    }

    public function index(Request $request)
    {
        $this->purchaseRepository->pushCriteria(new RequestCriteria($request));
        $purchases = $this->purchaseRepository->all();

        return view('purchases.index')->with('purchases', $purchases);
    }

    public function create()
    {
        return view('purchases.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $purchase = $this->purchaseRepository->create($input);

        Flash::success('Purchase saved successfully.');

        return redirect(route('purchases.index'));
    }

    public function show($id)
    {
        $purchase = $this->purchaseRepository->findWithoutFail($id);

        if (empty($purchase)) {
            Flash::error('Purchase not found');

            return redirect(route('purchases.index'));
        }

        return view('purchases.show')->with('purchase', $purchase);
    }

    public function edit($id)
    {
        $purchase = $this->purchaseRepository->findWithoutFail($id);

        if (empty($purchase)) {
            Flash::error('Purchase not found');

            return redirect(route('purchases.index'));
        }

        return view('purchases.edit')->with('purchase', $purchase);
    }

    public function update($id, Request $request)
    {
        $purchase = $this->purchaseRepository->findWithoutFail($id);

        if (empty($purchase)) {
            Flash::error('Purchase not found');

            return redirect(route('purchases.index'));
        }

        $purchase = $this->purchaseRepository->update($request->all(), $id);

        Flash::success('Purchase updated successfully.');

        return redirect(route('purchases.index'));
    }

    public function destroy($id)
    {
        $purchase = $this->purchaseRepository->findWithoutFail($id);

        if (empty($purchase)) {
            Flash::error('Purchase not found');

            return redirect(route('purchases.index'));
        }

        $this->purchaseRepository->delete($id);

        Flash::success('Purchase deleted successfully.');

        return redirect(route('purchases.index'));
    }
}
