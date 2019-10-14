<?php

namespace App\Controllers\Wishlist;

use App\Controllers\BaseController;
use App\Entities\Wishlist;
use App\Libraries\Exporter;
use App\Models\WishlistDetailModel;
use App\Models\WishlistModel;
use App\Models\WishlistSupportModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\Response;
use ReflectionException;

class Wishlists extends BaseController
{
    private $wishlist;

    public function __construct()
    {
        $this->wishlist = new WishlistModel();
    }

    /**
     * Show index wishlist data.
     *
     * @return string
     */
    public function index()
    {
        must_authorized(PERMISSION_WISHLIST_VIEW);

        $title = 'Wishlist';
        $data = $this->wishlist->filter($_GET);

        if ($this->request->getGet('export')) {
            $exporter = new Exporter();
            $filePath = $exporter->exportFromArray($title, $data->asArray()->findAll());
            return $this->response->download($filePath, null, true);
        } else {
            $wishlists = $data->paginate();
            $pager = $this->wishlist->pager;
        }

        return view('wishlists/index', compact('title', 'wishlists', 'pager'));
    }

    /**
     * Show single wishlist data.
     *
     * @param $id
     * @return string
     */
    public function show($id)
    {
        must_authorized(PERMISSION_WISHLIST_VIEW);

        $title = 'View wishlist';
        $wishlist = $this->wishlist->find($id);

        $wishlistDetail = new WishlistDetailModel();
        $wishlistDetails = $wishlistDetail->where(['wishlist_id' => $id])->findAll();

        return view('wishlists/view', compact('wishlist', 'wishlistDetails', 'title'));
    }

    /**
     * Show create wishlist data form.
     *
     * @return string
     */
    public function new()
    {
        must_authorized(PERMISSION_WISHLIST_CREATE);

        $title = 'New wishlist';

        return view('wishlists/new', compact('title'));
    }

    /**
     * Save new wishlist data.
     *
     * @return RedirectResponse
     * @throws ReflectionException
     */
    public function create()
    {
        must_authorized(PERMISSION_WISHLIST_CREATE);

        if ($this->validate('wishlists')) {
            $wishData = $this->request->getPost();
            $wishData['user_id'] = auth('id');
            if ($this->request->getPost('is_completed')) {
                $wishData['completed_at'] = date('Y-m-d H:i:s');
                $wishData['target'] = format_date($wishData['target']);
            }

            $this->db->transStart();

            $wishlistId = $this->wishlist->insert($wishData);

            $wishlistDetail = new WishlistDetailModel();
            foreach (if_empty($this->request->getPost('details'), []) as $detail) {
                $wishlistDetail->insert([
                    'wishlist_id' => $wishlistId,
                    'detail' => $detail['detail']
                ]);
            }

            $this->db->transComplete();

            if ($this->db->transStatus()) {
                return redirect()->to('/wishlists')
                    ->with('status', 'success')
                    ->with('message', "Wishlist {$this->request->getPost('wish')} successfully created");
            }
        }

        return redirect()->back()->withInput()
            ->with('status', 'warning')
            ->with('message', "Create wishlist {$this->request->getPost('wish')} failed, try again or contact our support");
    }

    /**
     * Show edit wishlist data form.
     *
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        must_authorized(PERMISSION_WISHLIST_EDIT);

        $title = 'Edit wishlist';
        $wishlist = $this->wishlist->find($id);

        $wishlistDetail = new WishlistDetailModel();
        $wishlistDetails = $wishlistDetail->where(['wishlist_id' => $id])->findAll();

        return view('wishlists/edit', compact('wishlist', 'wishlistDetails', 'title'));
    }

    /**
     * Update wishlist data.
     *
     * @param $id
     * @return RedirectResponse
     * @throws ReflectionException
     */
    public function update($id)
    {
        must_authorized(PERMISSION_WISHLIST_EDIT);

        if ($this->validate('wishlists')) {
            $wishData = $this->request->getPost();
            if ($this->request->getPost('is_completed')) {
                $wishData['target'] = format_date($wishData['target']);
            }

            $this->db->transStart();

            $this->wishlist->update($id, $wishData);

            $wishlistDetail = new WishlistDetailModel();
            $wishlistDetail->where('wishlist_id', $id)->delete();
            foreach (if_empty($this->request->getPost('details'), []) as $detail) {
                $wishlistDetail->insert([
                    'wishlist_id' => $id,
                    'detail' => $detail['detail']
                ]);
            }

            $this->db->transComplete();

            if ($this->db->transStatus()) {
                return redirect()->to('/wishlists')
                    ->with('status', 'success')
                    ->with('message', "Wishlist {$this->request->getPost('wish')} successfully updated");
            }
        }

        return redirect()->back()->withInput()
            ->with('status', 'danger')
            ->with('message', "Update wishlist {$this->request->getPost('wish')} failed");
    }

    /**
     * Delete wishlist data.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        must_authorized(PERMISSION_WISHLIST_DELETE);

        $wishlist = $this->wishlist->find($id);

        if ($this->wishlist->delete($id)) {
            return redirect()->back()
                ->with('status', 'warning')
                ->with('message', "Wishlist {$wishlist->wish} successfully deleted");
        }

        return redirect()->back()
            ->with('status', 'danger')
            ->with('message', "Delete wishlist {$wishlist->wish} failed");
    }

    /**
     * Support wishlist data.
     *
     * @param $id
     * @return Response
     * @throws ReflectionException
     */
    public function support($id)
    {
        must_authorized(PERMISSION_WISHLIST_CREATE);

        $wishlist = $this->wishlist->find($id);

        $support = $this->request->getPost('support');

        $this->db->transStart();

        $this->wishlist->update($id, ['total_support' => $wishlist->total_support + $support]);

        $wishlistSupport = new WishlistSupportModel();
        if ($support > 0) {
            $wishlistSupport->insert([
                'wishlist_id' => $id,
                'user_id' => auth('id')
            ]);
        } else {
            $wishlistSupport->where([
                'wishlist_id' => $id,
                'user_id' => auth('id')
            ])->delete();
        }

        $this->db->transComplete();

        if ($this->db->transStatus()) {
            return $this->response->setJSON([
                'status' => 'success',
                'support' => $support,
                'total' => $wishlist->total_support + $support,
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'support' => $support,
            'message' => 'Something went wrong when support the wishlist',
        ]);
    }
}
