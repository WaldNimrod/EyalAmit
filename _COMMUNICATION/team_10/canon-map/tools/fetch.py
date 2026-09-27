import urllib.request, time, os, sys
BASE="http://eyalamit-co-il-2026.s887.upress.link"
pages={"home":"/","method":"/method/","repair":"/repair/","contact":"/contact/","books":"/books/",
"kushi":"/books/kushi-blantis/","snoring":"/snoring-sleep-apnea/","lessons":"/lessons/",
"testimonials":"/testimonials/","learning":"/learning/","mokesh":"/eyal-amit/mokesh-dahiman/",
"press":"/press/","qr1":"/qr/qr1/","qrhub":"/qr/","faq":"/faq/","bags":"/bags/","eyal":"/eyal-amit/",
"treatment":"/treatment/","shop":"/shop/","blog":"/blog/","en":"/en/","hist":"/historical-articles/"}
for k,p in pages.items():
    for a in range(3):
        try:
            h=urllib.request.urlopen(urllib.request.Request(BASE+p,headers={"User-Agent":"canon-map/1"}),timeout=20).read()
            open(k+".html","wb").write(h); print(k,len(h)); break
        except Exception as e:
            print(k,"retry",e); time.sleep(3)
    time.sleep(0.5)
