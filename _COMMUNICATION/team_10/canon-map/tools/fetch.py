import urllib.request, time, os, sys
BASE="http://eyalamit-co-il-2026.s887.upress.link"
pages={"home":"/","method":"/method/","repair":"/repair/","contact":"/contact/","books":"/books/",
"kushi":"/books/kushi-blantis/","snoring":"/snoring-sleep-apnea/","lessons":"/lessons/",
"testimonials":"/testimonials/","learning":"/learning/","mokesh":"/eyal-amit/mokesh-dahiman/",
"press":"/press/","qr1":"/qr/qr1/","qrhub":"/qr/","faq":"/faq/","bags":"/bags/","eyal":"/eyal-amit/",
"treatment":"/treatment/","post":"/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-2/","shop":"/shop/","blog":"/blog/","en":"/en/","hist":"/historical-articles/"}
for k,p in pages.items():
    for a in range(3):
        try:
            h=urllib.request.urlopen(urllib.request.Request(BASE+p,headers={"User-Agent":"canon-map/1"}),timeout=20).read()
            open(k+".html","wb").write(h); print(k,len(h)); break
        except Exception as e:
            print(k,"retry",e); time.sleep(3)
    time.sleep(0.5)
