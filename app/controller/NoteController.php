<?php
    class NoteController extends AutoLoader {
        public function __construct() {
            $this->noteModel = $this->model('NoteModel');
        }
        // Call get note function 
        public function index() {
            $this->getNotesCon();
        }
        // Get notes from user by id from the db
        public function getNotesCon() {
            $notes =  $this->noteModel->getNotesModel($_SESSION['userId']);
            $infoData = ['notes' => $notes, 'errorMess' => '']; 
            $this->view('/pages/note', $infoData);
        }
        private function emptyData() {
            $infoData = ['notes' => array('userId' => '', 'noteId' => '', 'textContent' => '', 'colorId' => '', 'createStamp' => ''), 'errorMess' => ''
            ];
            return $infoData;
        }
        // Update note by 
        public function updateNoteCon() {
            $infoData = $this->emptyData();
            if (isset($_GET['action'])) {
                if($_GET['action'] === '_UPDATE') {
                    if(empty($_GET['textContent'])) {
                        $infoData['errorMess'] = "Please enter some content in the note to be saved.";
                    } else {
                        $_GET['textContent'] = filterString($_GET['textContent']);
                        if($_GET['textContent']=== false) {
                            $infoData['errorMess'] = "Please enter valid content in the note.";
                        } else {
                            $infoData['noteId'] = trim($_GET['noteId']);
                            $infoData['textContent'] = trim($_GET['textContent']);
                            $infoData['colorId'] = $_GET['colorId'];
                            $tempUpdate = $this->noteModel->updateNoteModel($infoData['noteId'], $infoData['textContent'], $infoData['colorId']);
                            if($tempUpdate) {
                            $infoData['errorMess'] = "The note is saved.";
                            } else {
                            $infoData['errorMess'] = 'Something went wrong, please try again.';
                            }
                        }
                    }
                }
            }
            $this->reloadPage($infoData);
        }
        // Delete note by id
        public function deleteNoteCon() {
            $infoData = $this->emptyData();
            $infoData['errorMess'] = ''; 
            if(isset($_GET['action'])) {
                if ($_GET['action'] === '_DELETE') {
                    if(empty($_GET['noteId'])) {
                        $infoData['errorMess'] = "The note could not been found, please refresh.";
                    } else {
                        $id = $_GET['noteId'];
                        $tempDelete = $this->noteModel->deleteNotesModel($id);
                        if($tempDelete === true) {
                            $infoData['errorMess'] = "The note is deleted.";
                        } else {
                            $infoData['errorMess'] = "Something went wrong please try again.";
                        }
                    }
                }
            }
            $this->reloadPage($infoData);
        }
        // Create note
        public function createNoteCon() {
            $infoData = $this->emptyData();
            $infoData['errorMess'] = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(empty($_POST['textContent'])) {
                    $infoData['errorMess'] = "Please enter some content in the note.";
                } else {
                    $_POST['textContent'] = filterString($_POST['textContent']);
                    if($_POST['textContent']=== false) {
                        $infoData['errorMess'] = "Please enter valid content in the note.";
                    } else {
                        $infoData['textContent'] = trim($_POST['textContent']);
                        $infoData['userId'] = $_SESSION['userId'];
                        $infoData['colorId'] = $_POST['colorId'];
                        $tempNote = $this->noteModel->createNoteModel($infoData['userId'], $infoData['textContent'], $infoData['colorId']);
                        if($tempNote === true) {
                            $infoData['errorMess'] = 'The note has been created.';
                        } else {
                            $infoData['errorMess'] = 'Something went wrong, please try again.';
                        }
                    }
                }
            }
            $this->reloadPage($infoData);
        }
        // Reopen page 
        private function reloadPage($infoData) {
            $tempErrorMess = $infoData['errorMess'];
            $notes =  $this->noteModel->getNotesModel($_SESSION['userId']);
            $infoData = ['notes' => $notes, 'errorMess' => $tempErrorMess]; 
            $this->view('/pages/note', $infoData);
        }
    }