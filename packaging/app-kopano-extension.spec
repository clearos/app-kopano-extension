
Name: app-kopano-extension
Epoch: 1
Version: 2.5.0
Release: 1%{dist}
Summary: Kopano Extension - API
License: ClearCenter
Group: Applications/API
Packager: ClearCenter
Vendor: ClearCenter
Source: app-kopano-extension-%{version}.tar.gz
Buildarch: noarch

%description
Kopano Extension description

%package core
Summary: Kopano Extension - API
Requires: app-base-core
Requires: app-contact-extension-core
Requires: app-mail-extension-core
Requires: app-openldap-core >= 1:2.2.0
Requires: app-openldap-directory-core
Requires: app-smtp-plugin-core
Requires: app-users-core

%description core
Kopano Extension description

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/kopano_extension
cp -r * %{buildroot}/usr/clearos/apps/kopano_extension/

install -D -m 0644 packaging/kopano.php %{buildroot}/var/clearos/openldap_directory/extensions/70_kopano.php

%post core
logger -p local6.notice -t installer 'app-kopano-extension-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/kopano_extension/deploy/install ] && /usr/clearos/apps/kopano_extension/deploy/install
fi

[ -x /usr/clearos/apps/kopano_extension/deploy/upgrade ] && /usr/clearos/apps/kopano_extension/deploy/upgrade

exit 0

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-kopano-extension-core - uninstalling'
    [ -x /usr/clearos/apps/kopano_extension/deploy/uninstall ] && /usr/clearos/apps/kopano_extension/deploy/uninstall
fi

exit 0

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/kopano_extension/packaging
%exclude /usr/clearos/apps/kopano_extension/unify.json
%dir /usr/clearos/apps/kopano_extension
/usr/clearos/apps/kopano_extension/deploy
/usr/clearos/apps/kopano_extension/language
/usr/clearos/apps/kopano_extension/libraries
/var/clearos/openldap_directory/extensions/70_kopano.php
