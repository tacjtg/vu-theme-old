<?xml version='1.0'?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

<xsl:output method='html'/>    

<xsl:template match="/">

<!-- XSL DATA RESULT PAGE -->

      <xsl:apply-templates select="//item[position() &lt; 150]" />      

<!-- CLOSE XSL DATA RESULT PAGE -->

</xsl:template>

<xsl:template match="item">   

  
<li>
<a href="{link}" target="_blank">   
        <xsl:call-template name="formatDate">
            <xsl:with-param name="date" select="pubDate"></xsl:with-param>
        </xsl:call-template>    
  <br />
   <strong><xsl:value-of select="title"/></strong></a>
</li>

</xsl:template>
  

<xsl:template name="formatDate">
<!-- template for reformatting the pubDate variable
<pubDate>Fri, 22 Oct 2010 14:30:00 CDT</pubDate>
-->
<xsl:param name="date"/>

<xsl:variable name="mapmonths" select="'#Jan@01#Feb@02#Mar@03#Apr@04#May@05#Jun@06#Jul@07#Aug@08#Sep@09#Oct@10#Nov@11#Dec@12'"></xsl:variable>
<xsl:variable name="day-stripped" select="normalize-space(substring-after($date, ','))"></xsl:variable>
<xsl:variable name="day" select="substring-before($day-stripped, ' ')"/>
<xsl:variable name="date-remainder" select="substring-after($day-stripped, ' ')"></xsl:variable>
<xsl:variable name="month" select="substring-before($date-remainder, ' ')"></xsl:variable>
<xsl:variable name="year" select="substring-before(substring-after($date-remainder, ' '), ' ')"></xsl:variable>

<xsl:variable name="fulltime" select="substring-after($day-stripped, $year)"></xsl:variable>
<xsl:variable name="zone" select="substring-after(substring-after(substring-after(substring-after(substring-after($date, ' '), ' '), ' '), ' '), ' ')" />

<xsl:variable name="hour" select="substring-before($fulltime, ':')" />
<xsl:variable name="min" select="substring-before(substring-after($fulltime, ':'), ':')" />

<!-- set up display of date and time -->
<xsl:value-of select="substring-before(substring-after($mapmonths, concat('#', $month, '@')), '#')"/>
<xsl:text>/</xsl:text>
<xsl:value-of select="$day"/>
<xsl:text>/</xsl:text>
<xsl:value-of select="$year"/>
<xsl:text> &#8212; </xsl:text>

<xsl:choose>
        <xsl:when test="$hour &lt;= 0">
                <xsl:text>TBA</xsl:text>
        </xsl:when>
        <xsl:otherwise>
                <xsl:choose>
				<xsl:when test="number($hour) &lt;= 0">
				<xsl:text>12:</xsl:text>
				<xsl:value-of select="$min" />
				<xsl:text> a.m. </xsl:text>
				</xsl:when>
				<xsl:when test="number($hour) = 12">
				<xsl:text>12:</xsl:text>
				<xsl:value-of select="$min" />
				<xsl:text> p.m. </xsl:text>
				</xsl:when>
				<xsl:when test="number($hour) &gt; 12">
				<xsl:value-of select="number($hour) - 12" />
				<xsl:text>:</xsl:text>
				<xsl:value-of select="$min" />
				<xsl:text> p.m. </xsl:text>
				</xsl:when>
				<xsl:otherwise>
				<xsl:value-of select="number($hour)" />
				<xsl:text>:</xsl:text>
				<xsl:value-of select="$min" />
				<xsl:text> a.m. </xsl:text>
				</xsl:otherwise>
				</xsl:choose>
		
        </xsl:otherwise>
</xsl:choose>


</xsl:template>
     
</xsl:stylesheet>