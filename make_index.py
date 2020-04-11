import codecs, sys

def german_key(text):
    return text.replace("ö", "oe").replace("ü", "ue").replace("ä", "ae").replace("Ö", "Oe").replace("Ü", "Ue").replace("Ä", "Ae")

page = 0
indexed = {}
with codecs.open(sys.argv[1], "r", "utf-8") as file:
    for line in file.readlines():
        lineClean = line.strip()
        try:
            page = int(lineClean)
        except ValueError:
            if lineClean in indexed:
                indexed[lineClean]+= " " + str(page)
            else: 
                indexed[lineClean] = str(page)
            
           
letter = ""
print("{{TOC}}")
for key in sorted(indexed, key=german_key):
    firstLetterGerman = german_key(key)[0]
    if firstLetterGerman is not letter:
        print("== " + firstLetterGerman + " ==")
        letter = firstLetterGerman
    print ("* " + key + " " + indexed[key])
