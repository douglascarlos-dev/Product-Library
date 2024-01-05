# Product Library

![Static Badge](https://img.shields.io/badge/Apache%20HTTP-%3E%3D2.4.52-cb2138) ![Static Badge](https://img.shields.io/badge/PHP-%3E%3D8.1-blue) ![Static Badge](https://img.shields.io/badge/Ubuntu-22.04-orange) ![Static Badge](https://img.shields.io/badge/PostgreSQL-14.8-blue)



### Biblioteca de imagens, vídeos e PDF para e-commerce.

Com o Product Library além de cadastrar as imagens do seu produto é possível cadastrar vídeos e pdf. Ao carregar os arquivos é coletado o seu tamanho, dimensões, data de atualização e outras informações.

```shell
# Diretórios, com seus subdiretórios e arquivos
  .
  └── subdomínio
      └── domínio
          └── produto
              ├── foto
              |    └── sku
              |         ├── sku_1.jpg
              |         ├── sku_2.jpg
              |         ├── sku_3.jpg
              |         └── sku_4.jpg
              ├── video
              |    ├── sku_1.mp4
              |    ├── sku_2.mp4
              |    ├── sku_1.mp4
              |    └── sku_2.mp4
              └── files
                   ├── nomeDoArquivo.pdf
                   ├── nomeDoArquivo.pdf
                   ├── nomeDoArquivo.pdf
                   └── nomeDoArquivo.pdf
```

### Foto

As fotos de um produto serão armazenadas dentro de uma pasta nomeada com o SKU do produto dentro da pasta foto.
Os arquivos serão nomeado com o SKU seguido de Underline ( _ ) e uma sequência numérica.
Será coletado a altura, largura, tamanho e data de carregamento do arquivo.
Varias fotos podem ser carregadas simultaneamente.

Um alerta ⚠️ será exibido para imagens com dimensões ou tamanho fora de especificação.

### Vídeo

Os vídeos serão armazenados dentro da pasta video.
Os arquivos serão nomeado com o SKU seguido de Underline ( _ ) e uma sequência numérica.
Caracteres especiais serão removidos do nome do arquivo.
Será coletado o tamanho e data de carregamento do arquivo.

Um alerta ⚠️ será exibido para imagens com tamanho fora de especificação.

### Arquivos

Os arquivos serão armazenados dentro da pasta files com o mesmo nome do arquivo carregado.
Caracteres especiais serão removidos do nome do arquivo.
Será coletado o tamanho e data de carregamento do arquivo.
Arquivos podem ser atualizados mantendo o mesmo endereço.

Um alerta ⚠️ será exibido para imagens com tamanho fora de especificação.

### API

GET host/produto/apiv1.php?sku=SKU

Substitua SKU pelo SKU do produto.

```shell
# json retornado
{
    "sku": "SKU",
    "photo": {
        "found": true,
        "count": 2,
        "url": [
            "https://HOST/produto/foto/SKU/SKU_1.jpg",
            "https://HOST/produto/foto/SKU/SKU_2.jpg"
        ],
        "name": [
            "SKU_1.jpg",
            "SKU_2.jpg"
        ]
    }
}
```
### Extensão de arquivos

Os arquivos podem ter várias extensões, não apenas as apresentadas aqui.

### CDN

Os arquivos podem ser enviados para a CDN Bunny.