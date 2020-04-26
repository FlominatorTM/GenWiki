REM goto folder where this script lies
pushd %~dp0
REM attach _sorted.txt to the input file name
python make_index.py "%1" > "%~dpn1_sorted.txt"
REM run again in order to extract only the notes
python make_index.py "%1" notes > "%~dpn1_notes.txt"