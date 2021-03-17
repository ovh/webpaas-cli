# webpaas

`webpaas` is the CLI for the OVHcloud Web PaaS, powered by Platform.sh.

It is based on the [Platform.sh CLI](https://github.com/platformsh/platformsh-cli) with a modified configuration file.

## Installation

Run this command to install the CLI:

```sh
curl -sfS https://eu.cli.webpaas.ovhcloud.com/installer | php
```

In some Windows terminals you may need to type `php.exe` instead of `php`.

## Usage

You can run the CLI in your shell by typing `webpaas`.

Use the 'list' command to get a list of available options and commands:

```sh
webpaas list
```

All commands have help, which you can see by running `webpaas help [cmd]` or `webpaas [cmd] -h`, e.g.:

```sh
webpaas projects -h
```

See the [Platform.sh CLI README](https://github.com/platformsh/platformsh-cli/blob/3.x/README.md) for more detailed usage information.

## Customization

You can configure the CLI via the user configuration file `~/.webpaas-cli/config.yaml`. The possible keys and their default values are listed in the [Platform.sh CLI README](https://github.com/platformsh/platformsh-cli/blob/3.x/README.md#customization).

Other customization is available via environment variables:

* `OVHCLOUD_WEBPAAS_CLI_DEBUG`: set to 1 to enable cURL debugging. _Warning_: this will print all request information in the terminal, including sensitive access tokens.
* `OVHCLOUD_WEBPAAS_CLI_DISABLE_CACHE`: set to 1 to disable caching
* `OVHCLOUD_WEBPAAS_CLI_HOME`: override the home directory (inside which the `.webpaas-cli` directory is stored)
* `OVHCLOUD_WEBPAAS_CLI_NO_COLOR`: set to 1 to disable colors in output
* `OVHCLOUD_WEBPAAS_CLI_NO_INTERACTION`: set to 1 to disable interaction (useful for scripting). _Warning_: this will bypass any confirmation questions.
* `OVHCLOUD_WEBPAAS_CLI_SESSION_ID`: change user session (default 'default'). The `session:switch` command (beta) is now available as an alternative.
* `OVHCLOUD_WEBPAAS_CLI_SHELL_CONFIG_FILE`: specify the shell configuration file that the installer should write to (as an absolute path). If not set, a file such as `~/.bashrc` will be chosen automatically. Set this to an empty string to disable writing to a shell config file.
* `OVHCLOUD_WEBPAAS_CLI_TOKEN`: an API token. *_Warning_*: An API token can act as the account that created it, with no restrictions. Use a separate machine account to limit the token's access. Additionally, storing a secret in an environment variable can be insecure. It may be better to use the `auth:api-token-login` command. The environment variable is preferable on CI systems like Jenkins and GitLab.
* `OVHCLOUD_WEBPAAS_CLI_UPDATES_CHECK`: set to 0 to disable the automatic updates check
* `OVHCLOUD_WEBPAAS_CLI_AUTO_LOAD_SSH_CERT`: set to 0 to disable automatic loading of an SSH certificate when running login or SSH commands
* `CLICOLOR_FORCE`: set to 1 or 0 to force colorized output on or off, respectively
* `http_proxy` or `https_proxy`: specify a proxy for connecting to the Web PaaS

## Updating

New releases of the CLI are made regularly. Update with this command:

```sh
webpaas up
```

## Building from source

You may wish to download the source code manually, instead of relying on the pre-made build and the automated installer.

Clone this repository, and then run: `./build.sh webpaas.phar`

This will build an executable file named `webpaas.phar`, which you can move into your PATH as `webpaas`.

Run `webpaas self:install` to complete the setup.
