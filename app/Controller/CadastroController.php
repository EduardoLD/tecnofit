<?php

Class CadastroController
{

    public function __construct()
    {
        global $p;
    
        $model = strToClass($p);
        $this->model = new Model;
    }

    public function index()
    {
        $p = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_SPECIAL_CHARS);

        carrega_twig('Lista_cadastros.twig', [
            'p'           => $p,
            'cabecalho'   => $this->model->execQuery("SELECT COLUMN_NAME fields FROM information_schema.columns WHERE table_schema = 'db_analise' AND table_name = '$p'"),
            'itens'       => $p != 'categorias' ? $this->model->execQuery("SELECT a.*, c.str_categoria FROM $p a INNER JOIN categorias c ON c.id = a.id_categoria ORDER BY a.id") : $this->model->execQuery("SELECT * FROM $p ORDER BY id"),
            'campeonatos' => $p == 'times' ? $this->model->execQuery("SELECT * FROM campeonatos ORDER BY str_campeonato") : ''
        ]);
    }

    public function inclusao()
    {
        $p = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_SPECIAL_CHARS);

        carrega_twig('Inclusao_cadastros.twig', [
            'p'           => $p,
            'cabec'       => $this->model->execQuery("SELECT COLUMN_NAME fields FROM information_schema.columns WHERE table_schema = 'db_analise' AND table_name = '$p'"),
            'campeonatos' => $p == 'times' ? $this->model->execQuery("SELECT * FROM campeonatos ORDER BY str_campeonato") : '',
            'categorias'  => $p != 'categorias' ? $this->model->execQuery("SELECT c.id, c.str_categoria FROM categorias c ORDER BY c.id") : ''
        ]);
    }

    public function alteracao($id)
    {
        $p = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_SPECIAL_CHARS);

        carrega_twig('Alteracao_cadastros.twig', [
            'p'           => $p,
            'id'          => $id,
            'op'          => filter_input(INPUT_GET, 'op', FILTER_SANITIZE_SPECIAL_CHARS),
            'cabec'       => $this->model->execQuery("SELECT COLUMN_NAME fields FROM information_schema.columns WHERE table_schema = 'db_analise' AND table_name = '$p'"),
            'campeonatos' => $p == 'times' ? $this->model->execQuery("SELECT * FROM campeonatos ORDER BY str_campeonato") : '',
            'dados'       => $this->model->execQuery("SELECT * FROM $p WHERE id = $id", false, false),
            'categorias'  => $p != 'categorias' ? $this->model->execQuery("SELECT c.id, c.str_categoria FROM categorias c ORDER BY c.id") : ''
        ]);
    }

    public function visualizacao($id)
    {
        $p = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_SPECIAL_CHARS);

        carrega_twig('Visualizacao_cadastros.twig', [
            'p'           => $p,
            'id'          => $id,
            'op'          => filter_input(INPUT_GET, 'op', FILTER_SANITIZE_SPECIAL_CHARS),
            'cabec'       => $this->model->execQuery("SELECT COLUMN_NAME fields FROM information_schema.columns WHERE table_schema = 'db_analise' AND table_name = '$p'"),
            'campeonatos' => $p == 'times' ? $this->model->execQuery("SELECT * FROM campeonatos ORDER BY str_campeonato") : '',
            'dados'       => $this->model->execQuery("SELECT * FROM $p WHERE id = $id", false, false),
            'categorias'  => $p != 'categorias' ? $this->model->execQuery("SELECT c.id, c.str_categoria FROM categorias c ORDER BY c.id") : ''
        ]);
    }

    public function exclusao($id)
    {
        $p = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_SPECIAL_CHARS);

        carrega_twig('Exclusao_cadastros.twig', [
            'p'           => $p,
            'id'          => $id,
            'op'          => filter_input(INPUT_GET, 'op', FILTER_SANITIZE_SPECIAL_CHARS),
            'cabec'       => $this->model->execQuery("SELECT COLUMN_NAME fields FROM information_schema.columns WHERE table_schema = 'db_analise' AND table_name = '$p'"),
            'campeonatos' => $p == 'times' ? $this->model->execQuery("SELECT * FROM campeonatos ORDER BY str_campeonato") : '',
            'dados'       => $this->model->execQuery("SELECT * FROM $p WHERE id = $id", false, false),
            'categorias'  => $p != 'categorias' ? $this->model->execQuery("SELECT c.id, c.str_categoria FROM categorias c ORDER BY c.id") : ''
        ]);
    }

    public function salvaInclusao()
    {
        $tab    = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS);
        $post   = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $mypost = array_map_recursive( fn($e) => html_entity_decode(htmlentities($e, ENT_QUOTES, 'UTF-8'), ENT_QUOTES , 'UTF-8') , $_POST);
        $cabec  = $this->model->execQuery("SELECT COLUMN_NAME fields FROM information_schema.columns WHERE table_schema = 'db_analise' AND table_name = '$tab' AND COLUMN_NAME <> 'id'");

        if ( $tab == 'gestao' ) {
            $mypost += [
                'dat_inicio'      => date('Y-m-d'),
                'flo_banca_final' => $mypost['flo_banca_inicial']
            ];
        }

        $this->model->insert($tab, $mypost, 1);
        
        $insert_id = $_SESSION['insert_id'];
        unset($_SESSION['insert_id']);

        if ( !empty($_FILES) && !empty($_FILES['str_logo']['name']) ) {
            $completeDir = $this->salva_arquivo($_FILES, $insert_id, $tab);

            if ( $tab == 'times' || $tab == 'campeonatos' ) {
                $this->model->execQuery("UPDATE $tab SET str_logo = '$completeDir' WHERE id = $insert_id");
            }
        }
        
        redirect('?p=' . $tab);
    }

    public function salvaAlteracao()
    {
        $id     = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $tab    = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS);
        $post   = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $mypost = array_map_recursive( fn($e) => html_entity_decode(htmlentities($e, ENT_QUOTES, 'UTF-8'), ENT_QUOTES , 'UTF-8') , $_POST);
        
        $this->model->update($tab, $mypost, "id = $id");
        
        if ( !empty($_FILES['str_logo']) && !empty($_FILES['str_logo']['name']) ) {
            $completeDir = $this->salva_arquivo($_FILES, $id, $tab);
            
            if ( $tab == 'times' || $tab == 'campeonatos' ) {
                $this->model->execQuery("UPDATE $tab SET str_logo = '$completeDir' WHERE id = $id");
            }
        }
        
        redirect('?p=' . $tab);
    }

    public function salvaExclusao()
    {
        $logo = filter_input(INPUT_POST, 'str_logo', FILTER_SANITIZE_SPECIAL_CHARS);
        $id   = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $tab  = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS);

        if ( !empty($logo) ) {

            if ( file_exists($logo) ) {
                unlink($logo);
            }

        }

        $this->model->delete($tab, "id = $id");
        redirect('?p=' . $tab);
    }

    public function salva_arquivo($files, $insert_id, $tab)
    {
        $file = $files['str_logo'];

        $arr_ext = $this->upload_formatos_permissao();
        $ext     = $this->get_file_extension($file['name']);

        //-- verifica a extensao do arquivo
        if (!in_array($ext, $arr_ext)) {
            alert('Extens�o (' . $ext . ') n�o permitida!');
            return false;

            //-- verifica o tamanho do arquivo
        } elseif (filesize($file['tmp_name']) > (((int) ini_get('upload_max_filesize')) * 1024 * 1024)) {
            // LIMITE PARA ANEXOS
            alert('Arquivo excede o tamanho de upload de ' . (ini_get('upload_max_filesize')) . '!');
            return false;

            //-- da prosseguimento ao upload do arquivo
        } else {
            //-- abre o arquivo para gravar no banco de dados
            $fp    = fopen($file['tmp_name'], 'r');
            $anexo = fread($fp, filesize($file['tmp_name']));
            fclose($fp);

            $fileName    = $insert_id . '.' . $ext;
            $dir         = 'app/View/Img/Logos/' . ucfirst($tab);
            $completeDir = $dir . '/' . $fileName;
            
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            if ( file_exists($completeDir) ) {
                unlink($completeDir);
            }
    
            file_put_contents($completeDir, $anexo);

            return $completeDir;
        }
    }

    protected static function get_file_extension($filename)
    {
        $pos_ponto = strrpos($filename, '.') + 1;
        $pos_fim   = strlen($filename) - $pos_ponto;
        return strtolower(substr($filename, $pos_ponto, $pos_fim));

    }

    //-- valida o formato de inclusao de arquivos de qualidade
    protected static function upload_formatos_permissao()
    {
        $perm = array('png', 'jpg', 'jpeg', 'jpe', 'tiff', 'tif', 'doc', 'docx', 'xlsx', 'xls', 'xlsm', 'ppt', 'pptx', 'ppsx', 'ppsm', 'dwg', 'pdf', 'zip', 'rar', 'vsd', 'mpp', 'txt', 'rtf', 'gif', 'xlsx', 'xlsb', 'docx', 'pptx', 'xml', 'msg', 'log', 'slddrw', 'pps');

        return $perm;
    }
}