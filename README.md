# php_framework
パーフェクトPHPの第8章を参考に自作フレームワークでミニブログを作成しました。


## フレームワークの使用手順

1. ドキュメントルートをwebディレクトリにする。(Apacheの設定ファイルから変更)

2. [アプリ名]Application.phpをルートディレクトリに作成。
このクラスはApplication.phpの子クラスなので、getRootDir()とregisterRoutes()という二つの抽象メソッドを実装する必要がある。

3. web/index.phpからbootstrap.php(オートロードクラスを実装している)と[アプリ名]Application.phpを読み込む。
   コードは以下の様。

```
$app = new MiniBlogApplication(false);
$app->run();
```

4. 実行されるメソッドの順番

Application.php
```
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
```

```
//Routerクラスのresolveメソッドを呼び出してルーティングパラメータを取得し、コントローラとアクション名を特定する。
public function run()
{
    try {
        $params = $this->router->resolve($this->request->getPathInfo());
        if ($params === false) {
            //例外処理
            throw new HttpNotFoundException('No route found for' . $this->request->getPathInfo());
        }

        $controller = $params['controller'];
        $action = $params['action'];

        $this->runAction($controller, $action, $params);

        $this->response->send();

    } catch (HttpNotFoundException $e) {
        $this->render404Page($e);

    } catch (UnauthorizedActionException $e) {
        list($controller, $action) = $this->login_action;
        $this->runAction($controller, $action);
    }
}
```

## 1機能の作成手順

1. データベースアクセス処理をDbRepositoryの子クラスに実装する。
2. ルーティングを[アプリ名]ApplicationクラスのregisterRoutes()メソッドに記述する。
3. Controllerクラスの子クラスであるAccountController.php(URLに対応する名前)を作る。
4. 作成したコントローラクラスにアクションを定義する。
5. アクションに対応したViewファイルを記述する。