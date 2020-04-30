REM goto folder where this script lies
pushd %~dp0

REM variable used to remove redundant double quotes
set source=%1

REM attach _sorted.txt to the input file name
python make_index.py "%source:"=%" > "%~dpn1_sorted.txt"
REM run again in order to extract only the notes
python make_index.py "%source:"=%" notes > "%~dpn1_notes.txt"