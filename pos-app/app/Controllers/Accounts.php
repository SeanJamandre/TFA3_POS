<?php
namespace App\Controllers;
use App\Models\CustomerModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
class Accounts extends \CodeIgniter\Controller
{
    protected $helpers = ['form', 'url'];
    private function modelFor(string $kind) {
        if (!in_array($kind, ['customers', 'users'], true)) throw PageNotFoundException::forPageNotFound();
        return $kind === 'users' ? new UserModel() : new CustomerModel();
    }
    public function index(string $kind) {
        return view('accounts/list', ['kind'=>$kind, 'rows'=>$this->modelFor($kind)->orderBy('id', 'DESC')->findAll()]);
    }
    public function form(string $kind, ?string $id=null) {
        $m=$this->modelFor($kind); $row=$id ? $m->find($id) : [];
        if ($id && !$row) throw PageNotFoundException::forPageNotFound();
        return view('accounts/form', compact('kind','row','id'));
    }
    public function save(string $kind, ?string $id=null) {
        $m=$this->modelFor($kind); $existing=$id ? $m->find($id) : [];
        if ($id && !$existing) throw PageNotFoundException::forPageNotFound();
        $data=['full_name'=>trim((string)$this->request->getPost('full_name'))];
        $rules=['full_name'=>'required|max_length[150]'];
        if ($kind==='customers') {
            $data['email']=trim((string)$this->request->getPost('email'));
            $rules['email']='required|valid_email|max_length[254]';
        } else {
            $data['username']=trim((string)$this->request->getPost('username'));
            // Only the numeric, server-selected record ID enters this rule.
            $rules['username']='required|alpha_numeric_punct|max_length[60]|is_unique[users.username'.($id ? ',id,'.(int)$id : '').']';
        }
        $v=service('validation'); $v->setRules($rules);
        $back=$kind.($id ? '/'.$id.'/edit' : '/new');
        if (!$v->run($data)) return redirect()->to(site_url($back))->withInput()->with('errors',$v->getErrors());
        $file=$kind==='users' && $id ? $this->request->getFile('avatar') : null;
        $filename=null; $target=null;
        if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            $v->reset();
            $v->setRules(['avatar'=>'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpeg,image/png]|ext_in[avatar,jpg,jpeg,png]|max_dims[avatar,4096,4096]']);
            if (!$v->withRequest($this->request)->run()) return redirect()->to(site_url($back))->withInput()->with('errors',$v->getErrors());
            $filename=bin2hex(random_bytes(16)).'.jpg';
            $target=FCPATH.'uploads/avatars/'.$filename;
            try {
                $dir=dirname($target);
                if (!is_dir($dir) && !mkdir($dir,0755,true) && !is_dir($dir)) throw new \RuntimeException('Upload directory unavailable.');
                service('image')->withFile($file->getTempName())->fit(256,256,'center')->convert(IMAGETYPE_JPEG)->save($target,85);
                $data['avatar']=$filename;
            } catch (\Throwable $e) {
                if (is_file($target)) unlink($target);
                log_message('error','Avatar preparation failed: {message}',['message'=>$e->getMessage()]);
                return redirect()->to(site_url($back))->withInput()->with('errors',['avatar'=>'Image could not be prepared. Try a different JPG or PNG.']);
            }
        }
        try {
            $ok=$id ? $m->update($id,$data) : $m->insert($data);
            if ($ok===false) throw new \RuntimeException('Database write failed.');
        } catch (\Throwable $e) {
            if ($target && is_file($target)) unlink($target);
            log_message('error','Account save failed: {message}',['message'=>$e->getMessage()]);
            return redirect()->to(site_url($back))->withInput()->with('errors',['save'=>'Unable to save. Check the values; usernames must be unique.']);
        }
        if ($filename && !empty($existing['avatar']) && preg_match('/^[a-f0-9]{32}\.jpg$/D',$existing['avatar'])) {
            $old=FCPATH.'uploads/avatars/'.$existing['avatar'];
            if (is_file($old)) unlink($old);
        }
        return redirect()->to(site_url($kind))->with('success','Account saved successfully.');
    }
}
