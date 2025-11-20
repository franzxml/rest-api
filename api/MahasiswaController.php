<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/MahasiswaModel.php';

class MahasiswaController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new MahasiswaModel();
    }

    // GET /mahasiswa
    public function index()
    {
        $data = $this->model->getAll();
        $this->response($data);
    }

    // GET /mahasiswa/{id}
    public function show($id)
    {
        $data = $this->model->find($id);

        if (!$data) {
            $this->response(["error" => "Data tidak ditemukan"], 404);
            return;
        }

        $this->response($data);
    }

    // POST /mahasiswa
    public function store()
    {
        $rawInput = file_get_contents("php://input");
        $input = json_decode($rawInput, true);

        if (!$input) {
            $this->response(["error" => "Body JSON tidak terbaca", "raw" => $rawInput], 400);
            return;
        }

        $result = $this->model->store($input);
        $this->response($result);
    }

    // PUT /mahasiswa/{id}
    public function update($id)
    {
        $rawInput = file_get_contents("php://input");
        $input = json_decode($rawInput, true);

        if (!$input) {
            $this->response(["error" => "Body JSON tidak terbaca", "raw" => $rawInput], 400);
            return;
        }

        $result = $this->model->update($id, $input);
        $this->response($result);
    }

    // DELETE /mahasiswa/{id}
    public function destroy($id)
    {
        $result = $this->model->delete($id);
        $this->response($result);
    }
}