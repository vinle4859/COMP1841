1. Edit.php testing errors:
- Forgot to get Module and User through questionID in edit.php (Undefine array
key error displayed in dropdown box)
- Missing fallback when user decided not to change into new image. This leads to 
deleting existing image from database.
