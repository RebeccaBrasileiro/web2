Create table FUNCIONARIO
(cod int(3), 
nome varchar(40),
salario float(9,2),
cargo varchar(30),
coddepto int(3),
comissao float(9,2),
primary key(cod));

Create table REQUISICAO
(codreq int(3),
codfunc int(3),
datareq date,
primary key(codreq),
foreign key (codfunc) references FUNCIONARIO(cod));