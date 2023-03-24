## iliskilerin dogrulugu
    do:sc:va
## Get ve Set leri olusturma
    do:ge:entities ETS
## Datatable olusturma
    $ php bin/console sg:datatable:generate AppBundle:Post
    
#Create query builder
    $em->getRepository()->createQueryBuilder('p')->where('p.firm = :firm')->setParameter(':firm', '1')->getQuery()->getArrayResult();
    $em->createQueryBuilder()->from("Staf","s")->select("s")->where('p.firm = :firm')->setParameter(':firm', '1')->getQuery()->getArrayResult();

#form generate
    $ php bin/console generate:doctrine:form AcmeBlogBundle:Post
    
#git add tamamı
    git add .

    git commit -m "message"
    git push origin tolga
    git checkout master
    git pull origin master
    git merge tolga
    git push origin master 
# if conflic 
    confilictleri duzeltip
    git add .
    git commit -m "mesaj"
    git push origin master
# git devamı
    git checkout tolga
    git pull origin master
    
    
#Use it: php /usr/local/bin/composer
