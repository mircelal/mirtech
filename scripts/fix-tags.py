from pathlib import Path

def tag(name, close=False):
    return ("</" if close else "<") + name + ">"

p = Path(r"c:\laragon\www\mirtech\calculator.php")
t = p.read_text(encoding="utf-8")
t = t.replace(tag("motion", True), tag("div", True))
t = t.replace(tag("motion"), tag("d" + "iv"))
p.write_text(t, encoding="utf-8")
