import codecs, sys

def german_key(text):
    return text.replace("ö", "oe").replace("ü", "ue").replace("ä", "ae").replace("Ö", "Oe").replace("Ü", "Ue").replace("Ä", "Ae")

if len(sys.argv) < 2:
    print("usage: " + sys.argv[0] + " <input file> ")
    print("usage: " + sys.argv[0] + " <input file> notes")
    sys.exit(1)

# either remove notes or limit output to them
doOnlyNotes = False
if len(sys.argv) > 2 and "notes" in sys.argv[2]:
    doOnlyNotes = True

page = 0
indexed = {}
with codecs.open(sys.argv[1], "r", "utf-8") as file:
    for line in file.readlines():
        lineClean = line.strip()
        if doOnlyNotes is False and "->" in lineClean:
            indexOfNote = lineClean.find(" -")
            if indexOfNote > -1:
                lineClean = lineClean[0:indexOfNote].strip()
         
        try:
            page = int(lineClean)
        except ValueError:
            if lineClean in indexed:
                indexed[lineClean]+= " " + str(page)
            else: 
                indexed[lineClean] = str(page)
           
letter = ""
if doOnlyNotes is False:
    print("{{TOC}}")
    
for key in sorted(indexed, key=german_key):
    firstLetterGerman = german_key(key)[0]
    if doOnlyNotes is False and firstLetterGerman is not letter:
        print("== " + firstLetterGerman + " ==")
        letter = firstLetterGerman
    if doOnlyNotes is False or "->" in key:
        print ("* " + key + " " + indexed[key])
