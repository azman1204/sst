**TEST**
```
* sample function dalam controller *
function actionList() {
        // panggil model
        // return semua data dlm table dlm bentuk array of obj (1 rekod dlm table)
        $data = \app\models\Pengguna::find()->all();
        //display data
        $arr = ['dat' => $data];
        return $this->render('senarai', $arr);
    }
```