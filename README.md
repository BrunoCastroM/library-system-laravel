# 📚 **Biblioteca Laravel - Sistema de Gerenciamento**

Bem-vindo ao sistema de gerenciamento de livros desenvolvido em **Laravel**! Este guia detalha os passos necessários para configurar e rodar o projeto localmente.

## **Instruções para Instalação e Uso do Projeto**

### **🚀 1. Pré-requisitos**

Certifique-se de ter as seguintes ferramentas instaladas no seu computador:

- **PHP** (versão 8.2 ou superior)
- **Composer** (gerenciador de dependências PHP)
- **Node.js** (para compilar o CSS e JS, caso necessário)
- **MySQL** (ou outro banco de dados compatível)
- **Git** (para clonar o repositório)
- **Servidor Local** (como Apache ou Nginx)

---

### **📥 2. Clonar o Repositório**

Primeiro, clone o repositório usando o Git:

```bash
git clone https://github.com/BrunoCastroM/library-system-laravel.git
```

Acesse o diretório do projeto:

```bash
cd biblioteca
```

---

### **📦 3. Instalar Dependências**

Instale as dependências do **Composer** e do **NPM**:

```bash
composer install
npm install
```

---

### **⚙️ 4. Configurar o Banco de Dados**

1. **Crie um novo banco de dados** no MySQL (ou SQLite, se preferir).
2. **Configure o arquivo `.env`**:
    - Copie o arquivo `.env.example` para `.env` (se não existir crie ele):
    - Edite o arquivo `.env` e atualize as configurações do banco de dados:
        
        ```
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3307
        DB_DATABASE=biblioteca
        DB_USERNAME=root
        DB_PASSWORD=
        ```
        

---

### **🔑 5. Gerar Chave da Aplicação**

Gere a chave do Laravel (Se necessário):

```bash
php artisan key:generate
```

---

### **📊 6. Migrar o Banco de Dados e Rodar Seeders**

Execute as migrações e seeders para criar as tabelas e popular os dados iniciais:

```bash
php artisan migrate --seed
```

- **O que será criado?**
    - Um usuário **administrador** com:
        - **Email:** `admin@example.com`
        - **Senha:** `password`
    - Um usuário de teste com:
        - **Email:** `test@example.com`

---

### **⚒️ 7. Compilar os Assets**

Compile os arquivos CSS e JS usando o Vite (Se necessário):

```bash
npm run build
```

Para desenvolvimento, você pode usar:

```bash
npm run dev
```

---

### **🌐 8. Iniciar o Servidor**

Inicie o servidor local do Laravel:

```bash
composer run dev
```

ou

```bash
php artisan serve
```

Acesse a aplicação no navegador:

```arduino
http://127.0.0.1:8000
```

---

### **9. Login no Sistema**

- **Administrador:**
    - **Email:** `admin@example.com`
    - **Senha:** `password`
- **Usuário de Teste:**
    - **Email:** `test@example.com`
    - **Senha:** `password`