# 🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine

Uma versão aprimorada, moderna e altamente especializada do **SendPortal** (plataforma open-source de email marketing e newsletters auto-hospedada), customizada profissionalmente com uma estética **Super 100% Vanta Black AMOLED**, motor de distribuição inteligente de **Múltiplas Chaves de API da Resend** e tradução integral de ponta a ponta para o **Português Brasileiro (PT-BR)**.

---

## 🌟 Principais Recursos e Diferenciais

### 1. 🌑 Visual Super 100% Vanta Black AMOLED & High Contrast Electric White
- **Verdadeiro Preto Puro (`#000000`)**: Otimizado especificamente para displays OLED/AMOLED, economizando energia e proporcionando conforto visual absoluto.
- **Contraste Ultra Elevado**: Tipografia, ícones e linhas em branco elétrico vibrante (`#FFFFFF`), eliminando listras acinzentadas, bordas desbotadas ou elementos com baixo contraste.
- **Microinterações e Polimento**: Menus laterais, cabeçalhos, cartões, formulários e modais reestilizados com foco em elegância minimalista e imersiva.

### 2. ⚡ Motor Resend Multi-Key (Até 10 Chaves Simultâneas)
- **Provedor Exclusivo & Otimizado**: Totalmente integrado à API da [Resend](https://resend.com), com classe adaptadora especializada (`ResendMailAdapter`).
- **Balanceamento Probabilístico Randomizado**: Para cada disparo individual, o sistema sorteia pseudo-aleatoriamente via gerador criptográfico seguro (`random_int`) uma chave ativa e saudável. Evita padrões lineares previsíveis e distribui o volume de forma uniforme.
- **Desativação Automática de Chaves Vazias**: Qualquer campo de chave deixado vazio ou com espaços em branco é imediatamente ignorado e desativado. Nenhuma chave inexistente ou vazia participa do pool de envios.
- **Monitoramento de Quota Diária (100 emails/dia por chave)**:
  - Cada chave do plano gratuito da Resend possui cota de 100 envios/dia (possibilitando até **1.000 envios/dia gratuitos** com 10 chaves ativas).
  - O sistema registra e monitora os envios em tempo real via Redis Cache (`resend_daily_key_{slot}_{Y-m-d}`).
  - Chaves com saldo disponível recebem prioridade máxima no pool. Caso atinjam a cota diária, o sistema preserva a chave e roteia o tráfego restante para as demais chaves com saldo.
- **Failover Instantâneo com Cooldown (HTTP 429 / 5xx)**:
  - Se uma chave atingir limite de taxa (429 Rate Limit) ou instabilidade temporária no endpoint, ela entra em *cooldown* de 60 segundos.
  - A tentativa de envio é instantaneamente transferida para outra chave ativa no pool, sem interrupção para a campanha.
- **Interface Reativa em Tempo Real**:
  - Formulário com detecção dinâmica: badges visuais informam instantaneamente se a chave está `● Ativa no Pool (Randomizada)` ou `○ Desativada (Vazia)` à medida que você digita ou cola uma chave.
- **Acesso Direto em 1 Clique**:
  - Rota dedicada e inteligente `/resend-keys` que redireciona automaticamente para o formulário de cadastro ou edição do serviço Resend no seu workspace atual.
  - Atalho limpo no menu lateral com o nome **Resend API**.

### 3. 🏷️ Gerenciador Completo de Etiquetas (Tags)
- Módulo nativo e totalmente funcional para criação, edição e exclusão de etiquetas.
- Associação fluida de tags aos inscritos e assinantes diretamente pela listagem e página de perfil do usuário.
- Filtros e segmentação de campanhas baseados em tags.

### 4. 🇧🇷 Tradução Completa para Português do Brasil (PT-BR)
- Todas as interfaces, botões, tabelas, notificações de sucesso/erro e relatórios traduzidos com precisão nativa.
- Middleware dedicado para assegurar o carregamento do locale `pt_BR` em todas as requisições HTTP do painel.

---

## 📁 Arquitetura e Estrutura de Arquivos

```
sendportal/
├── app/
│   ├── Adapters/
│   │   └── ResendMailAdapter.php      # Núcleo do motor Multi-Key Resend (randomização, failover, cotas)
│   ├── Http/
│   │   └── Middleware/
│   │       └── LocaleMiddleware.php   # Força e assegura o locale pt_BR nas requisições
│   └── Providers/
│       └── AppServiceProvider.php     # Registro do ID 8 (Resend) na fábrica de adaptadores e rota /resend-keys
├── config/
│   └── app.php                        # Configurações de timezone e locale do Laravel
├── lang/
│   ├── pt-BR.json                     # Dicionário JSON raiz PT-BR
│   ├── pt_BR.json                     # Fallback de dicionário JSON
│   └── vendor/sendportal/pt_BR.json   # Tradução dos componentes internos do pacote SendPortal
├── public/
│   └── css/
│       └── amoled-theme.css           # Folha de estilos 100% Vanta Black AMOLED & High Contrast
├── resources/
│   └── views/
│       └── vendor/sendportal/
│           ├── email_services/        # Telas de cadastro, edição e opções do Resend API
│           ├── layouts/               # Sidebar, header, cartões e layout base AMOLED
│           ├── tags/                  # Interface do gerenciador de etiquetas
│           ├── campaigns/             # Telas de criação, templates e relatórios de campanhas
│           └── subscribers/           # Listagem, importação e visualização de inscritos
├── supervisord.conf                   # Gerenciamento de processos (Nginx/PHP/Queue Worker)
├── entrypoint.sh                      # Script de inicialização (migrations, permissões, cache)
├── Dockerfile                         # Imagem Docker otimizada baseada em PHP 8.2 Alpine
├── docker-compose.yml                 # Orquestração do App, PostgreSQL 15 e Redis 7
├── .env.example                       # Modelo de variáveis de ambiente
└── README.md                          # Esta documentação completa
```

---

## 🛠️ Como Executar o Projeto

### Pré-requisitos
- [Docker](https://www.docker.com/) e [Docker Compose](https://docs.docker.com/compose/) instalados.

### Passo 1: Clonar o Repositório
```bash
git clone https://github.com/MateusCelestinoProX/sendportal.git
cd sendportal
```

### Passo 2: Configurar o Ambiente
Copie o arquivo `.env.example` para `.env`:
```bash
cp .env.example .env
```

### Passo 3: Iniciar os Contêineres
Suba a infraestrutura completa (Aplicação + PostgreSQL 15 + Redis 7):
```bash
docker compose up -d
```

### Passo 4: Acessar no Navegador
A aplicação estará disponível em:
👉 **[http://localhost:8080](http://localhost:8080)**

---

## 🔑 Configuração das Chaves Resend

1. Acesse o painel e crie/faça login na sua conta de administrador.
2. No menu lateral esquerdo, clique no item **Resend API** (ou navegue diretamente até `http://localhost:8080/resend-keys`).
3. Insira as suas chaves de API da Resend (ex: `re_123456789...`) nos campos desejados (Chave 1 a Chave 10).
4. Os campos que você preencher ficarão com o status `● Ativa no Pool (Randomizada)`. Os campos em branco ficarão como `○ Desativada (Vazia)`.
5. Salve as alterações.
6. Pronto! Seus disparos serão distribuídos de forma segura, inteligente e balanceada por todas as chaves ativas.

---

## 🛡️ Segurança e Privacidade
- O arquivo `.env` e a pasta `/data` (onde ficam os dados brutos de PostgreSQL e storage) estão incluídos no `.gitignore`.
- Nunca faça commit de suas chaves de API ou segredos do sistema.
- A rotação de chaves e o isolamento de contingência protegem suas campanhas contra paralisações acidentais por estouro de cota da Resend.

---

## 📄 Licença
Este projeto é baseado no [SendPortal Original](https://github.com/mettle/sendportal) da Mettle, sob licença MIT. Todas as modificações estéticas, de tradução e motor Multi-Key são de autoria e propriedade de Mateus Celestino.
