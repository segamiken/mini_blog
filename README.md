# php_framework
パーフェクトPHPの第8章を参考に自作フレームワークでミニブログを作成しました。


## フレームワークの使用手順

1. ドキュメントルートをwebディレクトリにする。(Apacheの設定ファイルから変更)

2. [アプリ名]Application.phpをルートディレクトリに作成。
このクラスはApplication.phpの子クラスなので、getRootDir()とregisterRoutes()という二つの抽象メソッドを実装する必要がある。

3. web/index.phpからbootstrap.php(オートロードクラスを実装している)と[アプリ名]Application.phpを読み込む。
   コードは以下の様。

    $app = new MiniBlogApplication(false);
    $app->run();


    public function __construct($debug = false)
        {
            $this->setDebugMode($debug);
            $this->initialize();
            $this->configure();
        }

    protected function initialize()
        {
            $this->request = new Request();
            $this->response = new Response();
            $this->session = new Session();
            $this->db_manager = new DbManager();
            $this->router = new Router($this->registerRoutes());
        }


## 1機能の作成手順

1. データベースアクセス処理をDbRepositoryの子クラスに実装する。
2. ルーティングを[アプリ名]ApplicationクラスのregisterRoutes()メソッドに記述する。
3. Controllerクラスの子クラスであるAccountController.php(URLに対応する名前)を作る。
4. 作成したコントローラクラスにアクションを定義する。
5. アクションに対応したViewファイルを記述する。