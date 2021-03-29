<?php
    class NoteModel {
        private $db;
        
        public function __construct() {
            $this->db = new Database;
        }
        
        public function getNotesModel(int $userId) {
            $this->db->query("SELECT * FROM `Note` WHERE `UserId` = :userId");
            $this->db->bindInt(':userId', $userId);
            $result = $this->db->resultSetNotes();
            return $result;
        }

        public function deleteNotesModel(int $noteId) {
            $this->db->query("DELETE `Note` FROM `Note` WHERE `NoteId` = :noteId");
            $this->db->bindInt(':noteId', $noteId);
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function updateNoteModel(int $noteId, string $textContent, int $colorId) {
            $this->db->query("UPDATE `Note` SET `TextContent` = :textContent, `ColorId` = :colorId
            WHERE `NoteId` = :noteId");
            $this->db->bindInt(':noteId', $noteId);
            $this->db->bindString(':textContent', $textContent);
            $this->db->bindInt(':colorId', $colorId);
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
        
        public function createNoteModel(int $userId, string $textContent, int $colorId) {
            $tempDate = new DateTime();
            $this->db->query("INSERT INTO `Note` (`UserId`, `CreateStamp`, `TextContent`, `ColorId`) VALUES (:userId, :createDate, :textContent, :colorId)");
            $this->db->bindInt(':userId', $userId);
            $this->db->bindDateTime(':createDate', $tempDate->format('Y-m-d H:i:s'));
            $this->db->bindString(':textContent', $textContent);
            $this->db->bindInt(':colorId', $colorId);
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }