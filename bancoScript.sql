CREATE TABLE Plataforma(
    nome_plataforma VARCHAR(255) NOT NULL,

    PRIMARY KEY (nome_plataforma),
    UNIQUE(nome_plataforma)
);

CREATE TABLE Genero(
    ID_genero INTEGER GENERATED BY DEFAULT AS IDENTITY,
    nome_genero VARCHAR(255) NOT NULL,

    PRIMARY KEY (ID_genero,nome_genero),
    UNIQUE(nome_genero)
);

CREATE TABLE Desenvolvedora(
    nome_desenvolvedora VARCHAR(255) NOT NULL,
    sede_desenvolvedora VARCHAR(255),
    url_site_d  VARCHAR(255),
    idependente BOOLEAN,

    PRIMARY KEY(nome_desenvolvedora),
    UNIQUE(nome_desenvolvedora)
);

CREATE TABLE Publicadora(
    nome_publicadora VARCHAR(255) NOT NULL,
    sede_publicadora VARCHAR(255),
    url_site_p VARCHAR(255),

    PRIMARY KEY(nome_publicadora),
    UNIQUE(nome_publicadora)
);

CREATE TABLE Jogo(
    nome_jogo VARCHAR(255) NOT NULL,
    serie_jogo VARCHAR(255) NOT NULL,
    nome_publi_jogo VARCHAR(255) NOT NULL,
    nome_desen_jogo VARCHAR(255) NOT NULL,
    data_publicacao DATE,

    PRIMARY KEY(nome_jogo),
    FOREIGN KEY (nome_publi_jogo) REFERENCES Publicadora(nome_publicadora),
    FOREIGN KEY (nome_desen_jogo) REFERENCES Desenvolvedora(nome_desenvolvedora)
);

CREATE TABLE Plataforma_Jogo(
    plataforma_rel VARCHAR(255) NOT NULL,
    jogo_plat_rel VARCHAR(255) NOT NULL,

    PRIMARY KEY (plataforma_rel, jogo_plat_rel),
    FOREIGN KEY (plataforma_rel) REFERENCES Plataforma(nome_plataforma),
    FOREIGN KEY (jogo_plat_rel)  REFERENCES Jogo(nome_jogo),
    
    UNIQUE(plataforma_rel, jogo_plat_rel)    
);

CREATE TABLE Genero_Jogo(
    genero_rel VARCHAR(255) NOT NULL,
    jogo_gen_rel VARCHAR(255) NOT NULL,

    PRIMARY KEY(genero_rel, jogo_gen_rel),
    FOREIGN KEY (genero_rel)     REFERENCES Genero(nome_genero),
    FOREIGN KEY (jogo_gen_rel)   REFERENCES Jogo(nome_jogo),
    
    UNIQUE(genero_rel, jogo_gen_rel)   
);

CREATE TABLE Lista_Favoritos(
    ID_jogo INTEGER GENERATED BY DEFAULT AS IDENTITY,
    jogo_nome_fav VARCHAR(255) NOT NULL,

    PRIMARY KEY (ID_jogo,jogo_nome_fav),
    FOREIGN KEY (jogo_nome_fav) REFERENCES Jogo(nome_jogo)
);