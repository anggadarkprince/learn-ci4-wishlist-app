<?php

namespace App\Controllers\Wishlist;

use App\Controllers\BaseController;
use App\Libraries\Exporter;
use App\Models\WishlistModel;
use CodeIgniter\HTTP\RedirectResponse;
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
        $title = 'View wishlist';
        $wishlist = $this->wishlist->find($id);

        return view('wishlists/view', compact('wishlist', 'title'));
    }

    /**
     * Show create wishlist data form.
     *
     * @return string
     */
    public function new()
    {
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
        if ($this->validate('wishlists')) {
            $wishData = $this->request->getPost();
            $wishData['user_id'] = auth('id');
            if ($this->request->getPost('is_completed')) {
                $wishData['completed_at'] = date('Y-m-d H:i:s');
                $wishData['target'] = format_date($wishData['target']);
            }

            $this->db->transStart();

            $this->wishlist->insert($wishData);

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
        $title = 'Edit wishlist';
        $wishlist = $this->wishlist->find($id);

        return view('wishlists/edit', compact('wishlist', 'title'));
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
        if ($this->validate('wishlists')) {
            $wishData = $this->request->getPost();
            if ($this->request->getPost('is_completed')) {
                $wishData['target'] = format_date($wishData['target']);
            }

            $this->db->transStart();

            $this->wishlist->update($id, $wishData);

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
}
