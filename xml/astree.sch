<?xml version="1.0" encoding="UTF-8"?>
<sch:schema xmlns:sch="http://purl.oclc.org/dsdl/schematron">
  <sch:title>Contraintes spécifiques à l’Astrée</sch:title>
  <sch:ns prefix="tei" uri="http://www.tei-c.org/ns/1.0"/>
  <sch:title>Astrée, repérage de quelques erreur</sch:title>
  <sch:pattern>
    <sch:rule context="tei:pb">
      <sch:report test="local-name(following-sibling::*[1]) = 'div'">Il est conseillé de mettre un saut de page au début d’un div (plutôt qu’en dehors), de manière à faciliter le retour à la page</sch:report>
    </sch:rule>
  </sch:pattern>
  <sch:pattern>
    <sch:rule context="tei:hi">
      <sch:report test="contains(@rend, 'indent')">hi est une balise de niveau caractère, l’indentation doit être portée par un bloc</sch:report>
      <sch:report test="contains(@rend, 'rule')">Une barre n’est pas un style caractère, préférer milestone[@unit="hr"]</sch:report>
    </sch:rule>
  </sch:pattern>
  <sch:pattern>
    <sch:rule context="tei:p">
      <sch:report test="not(text()[normalize-space(.)!='']) and count(tei:hi) = 1">Est-ce que cette mise en forme pour tout le paragraphe n’a pas un sens sémantique ? Sinon reporter dans p/@rend</sch:report>
      <sch:report test="not(text()[normalize-space(.)!='']) and count(tei:title) = 1">Est-ce qu’il s’agit bien d’un titre d’ouvrage cité ?</sch:report>
    </sch:rule>
  </sch:pattern>
</sch:schema>
